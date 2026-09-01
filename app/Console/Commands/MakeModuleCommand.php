<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:module', description: 'Scaffolding de un nuevo módulo del monolito modular')]
final class MakeModuleCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'make:module {name : Nombre del módulo (ej: Invoicing, Scheduling)} {--force : Sobrescribe si ya existe}';

    /**
     * @var string
     */
    protected $description = 'Crea la estructura base de un módulo en app/Modules/{Name}Module y lo registra en bootstrap/providers.php';

    private Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle(): int
    {
        $rawName = (string) $this->argument('name');
        $force = (bool) $this->option('force');

        $module = $this->normalizeModuleName($rawName);

        if ($module === '') {
            $this->error('Nombre de módulo inválido.');

            return self::FAILURE;
        }

        $basePath = app_path('Modules/'.$module);

        if ($this->files->isDirectory($basePath) && ! $force) {
            $this->error("El módulo [{$module}] ya existe en app/Modules/{$module}. Usa --force para sobrescribir.");

            return self::FAILURE;
        }

        $this->info("Creando módulo [{$module}]...");

        $directories = [
            'Actions',
            'Data',
            'Enums',
            'Exceptions',
            'Models',
            'Policies',
            'Providers',
            'Resources',
            'Rules',
            'Services',
            'Support',
            'Livewire',
            'Tests/Unit',
            'Tests/Feature',
        ];

        foreach ($directories as $dir) {
            $path = $basePath.'/'.$dir;

            if (! $this->files->isDirectory($path)) {
                $this->files->makeDirectory($path, 0755, true);
            }

            // .gitkeep para que git trackee directorios vacíos
            $gitkeep = $path.'/.gitkeep';
            if (! $this->files->exists($gitkeep)) {
                $this->files->put($gitkeep, '');
            }
        }

        // Providers stub
        $providerClass = $module.'ServiceProvider';
        $providerNamespace = 'App\\Modules\\'.$module.'\\Providers';
        $providerPath = $basePath.'/Providers/'.$providerClass.'.php';

        if (! $this->files->exists($providerPath) || $force) {
            $this->files->put($providerPath, $this->buildProviderStub($module, $providerClass, $providerNamespace));
            $this->line("  <fg=gray>→ Providers/{$providerClass}.php</>");
        }

        // resources/views/modules/{kebab}
        $kebab = Str::kebab(Str::replaceLast('Module', '', $module));
        $viewPath = resource_path('views/modules/'.$kebab);
        if (! $this->files->isDirectory($viewPath)) {
            $this->files->makeDirectory($viewPath, 0755, true);
            $this->files->put($viewPath.'/.gitkeep', '');
            $this->line("  <fg=gray>→ resources/views/modules/{$kebab}/</>");
        }

        // Registro en bootstrap/providers.php
        $registered = $this->registerProvider($providerNamespace.'\\'.$providerClass);

        $this->newLine();
        $this->info("Módulo [{$module}] creado correctamente.");

        if ($registered) {
            $this->info('Provider registrado en bootstrap/providers.php');
        } else {
            $this->warn('Provider ya estaba registrado o no se pudo registrar automáticamente. Verifica bootstrap/providers.php');
        }

        $this->newLine();
        $this->line('Siguiente paso:');
        $this->line("  <fg=cyan>php artisan make:model {$module}/Models/Example -m</>  (dentro del módulo)");
        $this->line('  Revisa README.md → Arquitectura y AGENTS.md → Architecture');

        return self::SUCCESS;
    }

    private function normalizeModuleName(string $raw): string
    {
        $raw = trim($raw);

        if ($raw === '') {
            return '';
        }

        // Soporta kebab, snake, espacios
        $studly = Str::studly(str_replace(['-', '_'], ' ', $raw));
        // Elimina sufijo Module si ya viene duplicado por studly malformado
        $studly = preg_replace('/Module$/', '', $studly) ?? $studly;

        if ($studly === '') {
            return '';
        }

        return $studly.'Module';
    }

    private function buildProviderStub(string $module, string $class, string $namespace): string
    {
        $kebab = Str::kebab(Str::replaceLast('Module', '', $module));

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use Illuminate\Support\ServiceProvider;

final class {$class} extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Descomenta si el módulo expone vistas propias:
        // \$this->loadViewsFrom(resource_path('views/modules/{$kebab}'), '{$kebab}');

        // Descomenta si el módulo expone migraciones propias (preferible mantenerlas en database/migrations):
        // \$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
PHP;
    }

    private function registerProvider(string $fqcn): bool
    {
        $providersPath = base_path('bootstrap/providers.php');

        if (! $this->files->exists($providersPath)) {
            return false;
        }

        $content = $this->files->get($providersPath);

        // Ya registrado
        if (str_contains($content, $fqcn.'::class') || str_contains($content, ltrim($fqcn, '\\').'::class')) {
            return false;
        }

        // Inserta use statement
        $useStatement = 'use '.$fqcn.';';
        if (! str_contains($content, $useStatement)) {
            // Inserta después del último use
            $content = preg_replace(
                '/^(use\s.+;)$/m',
                '$1',
                $content,
                -1,
                $count
            );

            // Estrategia simple: reemplaza el primer use por bloque con nuevo use
            // Buscamos el último use y lo extendemos
            if (preg_match_all('/^use\s.+;$/m', $content, $matches, PREG_OFFSET_CAPTURE) === false) {
                return false;
            }

            $lastUse = end($matches[0]);
            if ($lastUse !== false) {
                $insertPos = $lastUse[1] + strlen($lastUse[0]);
                $content = substr_replace($content, "\n".$useStatement, $insertPos, 0);
            } else {
                // Fallback: tras <?php
                $content = str_replace('<?php', "<?php\n\n".$useStatement, $content);
            }
        }

        // Inserta en array return
        $shortClass = Str::afterLast($fqcn, '\\');
        $entry = '    '.$shortClass.'::class,';

        // Evita duplicado por short name
        if (str_contains($content, $entry)) {
            $this->files->put($providersPath, $content);

            return true;
        }

        // Inserta antes del cierre ];
        $content = preg_replace('/\n\];\s*$/', "\n".$entry."\n];\n", $content, 1);

        if ($content === null) {
            return false;
        }

        $this->files->put($providersPath, $content);

        return true;
    }
}
