<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

it('prohibits App\\Models\\User legacy namespace', function (): void {
    $files = File::allFiles(app_path());
    $violations = [];

    foreach ($files as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }

        $content = $file->getContents();

        if (str_contains($content, 'App\\Models\\User') || str_contains($content, 'App\Models\User')) {
            $violations[] = $file->getRelativePathname();
        }
    }

    expect($violations)->toBeEmpty(
        'Usa App\\Modules\\UserModule\\Models\\User. Violaciones en: '.implode(', ', $violations)
    );
});

it('prohibits cross-module DB::table access', function (): void {
    // Mapa módulo → tablas prohibidas (propiedad del otro módulo)
    $rules = [
        'TaskModule' => ['users', 'password_reset_tokens', 'sessions'], // pertenece a UserModule
        'UserModule' => ['tasks'], // pertenece a TaskModule
        'CoreModule' => ['tasks', 'users'],
    ];

    $violations = [];

    foreach ($rules as $module => $forbiddenTables) {
        $path = app_path("Modules/{$module}");

        if (! is_dir($path)) {
            continue;
        }

        foreach (File::allFiles($path) as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $content = $file->getContents();

            foreach ($forbiddenTables as $table) {
                // Detecta DB::table('xxx') o DB::table("xxx")
                if (preg_match('/DB::table\s*\(\s*[\'"]'.$table.'[\'"]\s*\)/', $content) === 1) {
                    $violations[] = "{$module}/{$file->getRelativePathname()} → DB::table('{$table}')";
                }
            }
        }
    }

    expect($violations)->toBeEmpty(
        'Acceso directo a tabla de otro módulo. Usa FindUser::run() o Eloquent relation. Violaciones: '.implode('; ', $violations)
    );
});

it('requires Actions to be final and not generic', function (): void {
    $paths = [app_path('Modules')];
    $violations = [];

    foreach ($paths as $base) {
        foreach (File::allFiles($base) as $file) {
            if (! str_contains($file->getPath(), DIRECTORY_SEPARATOR.'Actions'.DIRECTORY_SEPARATOR)) {
                continue;
            }

            if ($file->getExtension() !== 'php') {
                continue;
            }

            $content = $file->getContents();

            // Debe ser final class y no nombres genéricos
            if (preg_match('/^\s*class\s+/m', $content) === 1 && preg_match('/\bfinal\s+class\b/', $content) !== 1) {
                $violations[] = $file->getRelativePathname().' → falta final';
            }

            if (preg_match('/class\s+(BaseAction|AbstractAction|GenericAction|ActionFactory|ActionManager)/', $content) === 1) {
                $violations[] = $file->getRelativePathname().' → nombre genérico prohibido';
            }
        }
    }

    expect($violations)->toBeEmpty(implode('; ', $violations));
});

it('requires Providers to be final', function (): void {
    $violations = [];

    foreach (File::allFiles(app_path('Modules')) as $file) {
        if (! str_contains($file->getPath(), DIRECTORY_SEPARATOR.'Providers'.DIRECTORY_SEPARATOR)) {
            continue;
        }

        if ($file->getExtension() !== 'php') {
            continue;
        }

        $content = $file->getContents();

        if (preg_match('/^\s*class\s+/m', $content) === 1 && preg_match('/\bfinal\s+class\b/', $content) !== 1) {
            $violations[] = $file->getRelativePathname();
        }
    }

    expect($violations)->toBeEmpty('Providers deben ser final: '.implode(', ', $violations));
});

it('ensures each module is registered in bootstrap/providers.php', function (): void {
    $providersFile = base_path('bootstrap/providers.php');
    $content = File::get($providersFile);

    $modules = collect(File::directories(app_path('Modules')))
        ->map(fn (string $path) => basename($path))
        ->filter(fn (string $m) => $m !== 'CoreModule' || true); // todos deben estar

    $missing = [];

    foreach ($modules as $module) {
        $expected = $module.'\\Providers\\'.$module.'ServiceProvider';

        if (! str_contains($content, $expected) && ! str_contains($content, str_replace('\\', '\\\\', $expected))) {
            $missing[] = $module;
        }
    }

    expect($missing)->toBeEmpty('Módulos no registrados en bootstrap/providers.php: '.implode(', ', $missing));
});

it('enforces module directory structure for TaskModule template', function (): void {
    $required = ['Actions', 'Data', 'Enums', 'Models', 'Policies', 'Providers', 'Http'];

    foreach ($required as $dir) {
        expect(is_dir(app_path("Modules/TaskModule/{$dir}")))->toBeTrue("TaskModule/{$dir} faltante — plantilla P0");
    }
});
