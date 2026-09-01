<x-layouts::app.simple :showHeader="false" :title="__('Welcome')">

    {{-- Public header (guest-safe) --}}
    <div class="sticky top-0 z-40 w-full border-b border-zinc-200/70 bg-white/80 backdrop-blur-xl dark:border-zinc-800 dark:bg-zinc-900/70">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5" wire:navigate>
                <span class="flex size-8 items-center justify-center rounded-lg bg-zinc-900 text-white dark:bg-white dark:text-zinc-900">
                    <x-app-logo-icon class="size-5" />
                </span>
                <span class="text-sm font-semibold tracking-tight">{{ config('app.name', 'CS Syncro') }}</span>
                <flux:badge size="sm" color="zinc" class="hidden sm:inline-flex">Monolito Modular</flux:badge>
            </a>

            <nav class="hidden items-center gap-6 text-sm font-medium md:flex">
                <a href="#features" class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">Funcionalidades</a>
                <a href="#architecture" class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">Arquitectura</a>
                <a href="#modules" class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">Módulos</a>
                <a href="#stack" class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">Stack</a>
            </nav>

            <div class="flex items-center gap-2">
                @auth
                    <flux:button href="{{ route('dashboard') }}" wire:navigate variant="primary" size="sm">
                        Dashboard
                    </flux:button>
                @else
                    <flux:button href="{{ route('login') }}" wire:navigate variant="ghost" size="sm" class="hidden sm:inline-flex">
                        Log in
                    </flux:button>
                    @if (Route::has('register'))
                        <flux:button href="{{ route('register') }}" wire:navigate variant="primary" size="sm">
                            Crear cuenta
                        </flux:button>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(60%_60%_at_50%_0%,theme(colors.zinc.100)_0%,transparent_60%)] dark:bg-[radial-gradient(60%_60%_at_50%_0%,theme(colors.zinc.800)_0%,transparent_60%)]"></div>
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-20 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
                <div class="flex flex-col gap-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <flux:badge color="zinc" icon="sparkles">Laravel 13 · Livewire 4 · Flux UI</flux:badge>
                        <flux:badge color="green" icon="check-circle">Pest · Pint · PHPStan lvl 7</flux:badge>
                    </div>

                    <div class="space-y-4">
                        <flux:heading level="1" size="xl" class="!text-4xl font-semibold tracking-tight sm:!text-5xl">
                            Sincroniza operaciones.<br />
                            <span class="text-zinc-500 dark:text-zinc-400">Escala sin microservicios.</span>
                        </flux:heading>
                        <flux:text class="!text-base leading-6 text-zinc-600 dark:text-zinc-400">
                            <strong class="font-semibold text-zinc-900 dark:text-white">{{ config('app.name', 'CS Syncro') }}</strong> es un monolito modular listo para crecer por dominios: acciones enfocadas, modelos en su módulo y límites claros — sin complejidad prematura.
                        </flux:text>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        @auth
                            <flux:button href="{{ route('dashboard') }}" wire:navigate variant="primary" icon="arrow-right">
                                Ir al dashboard
                            </flux:button>
                        @else
                            <flux:button href="{{ route('register') }}" wire:navigate variant="primary" icon="arrow-right">
                                Empezar ahora
                            </flux:button>
                            <flux:button href="{{ route('login') }}" wire:navigate variant="outline" icon="arrow-right-start-on-rectangle">
                                Ya tengo cuenta
                            </flux:button>
                        @endauth
                        <flux:button href="https://laravel.com/docs" target="_blank" variant="ghost" icon="book-open-text">
                            Documentación
                        </flux:button>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 pt-2 text-xs text-zinc-500 dark:text-zinc-400">
                        <span class="inline-flex items-center gap-1.5"><flux:icon.check-circle class="size-4 text-green-600" /> SQLite local · Redis opcional</span>
                        <flux:separator vertical class="hidden h-3 sm:block" />
                        <span class="inline-flex items-center gap-1.5"><flux:icon.shield-check class="size-4" /> Fortify + 2FA + Passkeys</span>
                    </div>
                </div>

                {{-- Visual preview --}}
                <div class="relative">
                    <div class="rounded-2xl border border-zinc-200 bg-white p-2 shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                        <div class="rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-950">
                            <div class="flex items-center gap-1.5 border-b border-zinc-200 px-4 py-3 dark:border-zinc-800">
                                <span class="size-2.5 rounded-full bg-red-400"></span>
                                <span class="size-2.5 rounded-full bg-yellow-400"></span>
                                <span class="size-2.5 rounded-full bg-green-400"></span>
                                <span class="ml-3 text-xs font-medium text-zinc-500">app/Modules</span>
                                <span class="ml-auto hidden text-xs text-zinc-400 sm:inline">bootstrap/providers.php · manual</span>
                            </div>
                            <div class="grid gap-4 p-4 sm:grid-cols-3">
                                <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
                                    <div class="flex items-center gap-2 text-xs font-semibold"><flux:icon.cube class="size-4" /> CoreModule</div>
                                    <flux:text class="mt-1 !text-xs">Acciones compartidas, infraestructura base y bootstrapping.</flux:text>
                                    <div class="mt-3 flex flex-wrap gap-1">
                                        <flux:badge size="sm" color="zinc">Actions</flux:badge>
                                        <flux:badge size="sm" color="zinc">Support</flux:badge>
                                    </div>
                                </div>
                                <div class="rounded-xl border border-zinc-900 bg-zinc-900 p-4 text-white dark:border-zinc-700 dark:bg-zinc-800">
                                    <div class="flex items-center gap-2 text-xs font-semibold"><flux:icon.users class="size-4" /> UserModule</div>
                                    <flux:text class="mt-1 !text-xs !text-zinc-300">Usuarios, roles, Livewire y componentes Flux reutilizables.</flux:text>
                                    <div class="mt-3 flex flex-wrap gap-1">
                                        <flux:badge size="sm" color="lime" class="!bg-white !text-zinc-900">Models</flux:badge>
                                        <flux:badge size="sm" color="zinc" class="!border-zinc-600 !text-zinc-200">Livewire</flux:badge>
                                    </div>
                                </div>
                                <div class="rounded-xl border border-dashed border-zinc-300 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-zinc-500"><flux:icon.plus class="size-4" /> Tu módulo</div>
                                    <flux:text class="mt-1 !text-xs">Employees · Scheduling · Operations… dentro del mismo proceso.</flux:text>
                                    <flux:text class="mt-3 !text-xs font-medium">php artisan make:module</flux:text>
                                </div>
                            </div>
                            <div class="px-4 pb-4">
                                <div class="flex gap-3 rounded-xl border border-blue-200 bg-blue-50 p-3 dark:border-blue-900/50 dark:bg-blue-950/30">
                                    <flux:icon.information-circle class="size-5 shrink-0 text-blue-600 dark:text-blue-400" />
                                    <div>
                                        <div class="text-sm font-semibold text-blue-900 dark:text-blue-100">Arquitectura intencional</div>
                                        <flux:text class="!text-sm !text-blue-800 dark:!text-blue-200">Límites claros, bajo acoplamiento. Cada módulo evoluciona independiente.</flux:text>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pointer-events-none absolute -bottom-6 -right-6 hidden rounded-xl border border-zinc-200 bg-white px-4 py-3 shadow-lg dark:border-zinc-700 dark:bg-zinc-900 lg:flex lg:items-center lg:gap-3">
                        <flux:icon.chart-bar class="size-8 text-zinc-900 dark:text-white" />
                        <div>
                            <div class="text-sm font-semibold leading-none">Pint · PHPStan · Pest</div>
                            <div class="text-xs text-zinc-500">composer test encadena lint → typecheck → test</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <flux:badge color="zinc" size="sm" class="mb-3">Por qué monolito modular</flux:badge>
            <flux:heading level="2" size="lg" class="!text-3xl tracking-tight">Simple cuando puede ser simple.</flux:heading>
            <flux:text class="mt-3">Suficiente estructura para escalar sin pagar el costo de microservicios antes de tiempo.</flux:text>
        </div>

        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex size-10 items-center justify-center rounded-xl bg-zinc-900 text-white dark:bg-white dark:text-zinc-900">
                    <flux:icon.squares-2x2 class="size-5" />
                </div>
                <flux:heading level="3" size="sm" class="mt-4">Módulos con dueño</flux:heading>
                <flux:text class="mt-1.5">Cada capacidad vive en `app/Modules/{Nombre}Module` con sus `Actions`, `Models` y `Livewire`. Sin `app/Models` genérico.</flux:text>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex size-10 items-center justify-center rounded-xl bg-zinc-900 text-white dark:bg-white dark:text-zinc-900">
                    <flux:icon.bolt class="size-5" />
                </div>
                <flux:heading level="3" size="sm" class="mt-4">Actions, no controllers gordos</flux:heading>
                <flux:text class="mt-1.5">La lógica va en acciones con nombre intencional: <code class="rounded bg-zinc-100 px-1 py-0.5 text-xs dark:bg-zinc-800">CreateSchedule</code> · <code class="rounded bg-zinc-100 px-1 py-0.5 text-xs dark:bg-zinc-800">PublishSchedule</code>.</flux:text>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex size-10 items-center justify-center rounded-xl bg-zinc-900 text-white dark:bg-white dark:text-zinc-900">
                    <flux:icon.shield-check class="size-5" />
                </div>
                <flux:heading level="3" size="sm" class="mt-4">Auth lista para producción</flux:heading>
                <flux:text class="mt-1.5">Fortify + 2FA + Passkeys, roles con Spatie Permission y gates de Horizon/Pulse por rol <code class="text-xs">admin</code>.</flux:text>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex size-10 items-center justify-center rounded-xl bg-zinc-900 text-white dark:bg-white dark:text-zinc-900">
                    <flux:icon.beaker class="size-5" />
                </div>
                <flux:heading level="3" size="sm" class="mt-4">Calidad integrada</flux:heading>
                <flux:text class="mt-1.5"><code class="text-xs">composer test</code> ejecuta Pint, PHPStan nivel 7 y Pest sobre `tests/` y `app/Modules/**/Tests` con SQLite en memoria.</flux:text>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex size-10 items-center justify-center rounded-xl bg-zinc-900 text-white dark:bg-white dark:text-zinc-900">
                    <flux:icon.paint-brush class="size-5" />
                </div>
                <flux:heading level="3" size="sm" class="mt-4">UI con Flux + Livewire</flux:heading>
                <flux:text class="mt-1.5">Más de 25 componentes activos y guías en `.ai/flux-*`. Layouts nuevos: <code class="text-xs">app.simple</code> y <code class="text-xs">app.centered</code>.</flux:text>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex size-10 items-center justify-center rounded-xl bg-zinc-900 text-white dark:bg-white dark:text-zinc-900">
                    <flux:icon.server class="size-5" />
                </div>
                <flux:heading level="3" size="sm" class="mt-4">Infra compartida</flux:heading>
                <flux:text class="mt-1.5">Una sola BD (migraciones en `database/migrations`), Redis para cache/queue/Pulse y Vite Plus para assets.</flux:text>
            </div>
        </div>
    </section>

    {{-- Architecture --}}
    <section id="architecture" class="mx-auto mt-16 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-6 dark:border-zinc-800 dark:bg-zinc-900 sm:p-8 lg:p-10">
            <div class="grid items-start gap-8 lg:grid-cols-2">
                <div>
                    <flux:badge color="zinc" icon="cube-transparent">Arquitectura</flux:badge>
                    <flux:heading level="2" class="mt-3 !text-2xl">Dependencias explícitas. Sin círculos.</flux:heading>
                    <flux:text class="mt-2">Scheduling puede necesitar Employees, pero a través de `FindEmployee::run()` — no con `DB::table('employees')`. Si aparece un ciclo `A → B → A`, el límite está mal definido.</flux:text>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-xl bg-white p-4 dark:bg-zinc-950">
                            <div class="text-xs font-semibold text-green-700 dark:text-green-400">DO</div>
                            <ul class="mt-2 list-disc space-y-1 pl-4 text-sm text-zinc-600 dark:text-zinc-400">
                                <li>Acciones pequeñas y enfocadas</li>
                                <li>Composición sobre jerarquías</li>
                                <li>Revisar SQL generado en crítico</li>
                            </ul>
                        </div>
                        <div class="rounded-xl bg-white p-4 dark:bg-zinc-950">
                            <div class="text-xs font-semibold text-red-600 dark:text-red-400">DON'T</div>
                            <ul class="mt-2 list-disc space-y-1 pl-4 text-sm text-zinc-600 dark:text-zinc-400">
                                <li>Repositories para ocultar Eloquent</li>
                                <li>DTOs por arrays simples</li>
                                <li>`app/Services` cajón de sastre</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-zinc-200 bg-white p-5 font-mono text-xs leading-6 dark:border-zinc-800 dark:bg-zinc-950">
                    <div class="text-zinc-500">app/Modules/</div>
                    <div>├── CoreModule/</div>
                    <div class="pl-4 text-zinc-600 dark:text-zinc-400">Actions · Support · Providers</div>
                    <div>├── UserModule/</div>
                    <div class="pl-4 text-zinc-600 dark:text-zinc-400">Models · Livewire · Providers</div>
                    <div>└── SchedulingModule/ <span class="text-zinc-500">(ejemplo)</span></div>
                    <div class="pl-4 text-zinc-600 dark:text-zinc-400">Actions · Models · Livewire · Tests</div>
                    <flux:separator class="my-4" />
                    <div class="font-sans text-xs">
                        <span class="font-semibold">Convención de nombres</span>
                        <span class="text-zinc-500">— intención sobre genericismo</span>
                    </div>
                    <div class="mt-1 flex flex-wrap gap-1 font-sans">
                        <flux:badge size="sm" color="green">CreateSchedule</flux:badge>
                        <flux:badge size="sm" color="green">PublishSchedule</flux:badge>
                        <flux:badge size="sm" color="green">AssignEmployee</flux:badge>
                        <flux:badge size="sm" color="red">ScheduleManager ✕</flux:badge>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modules --}}
    <section id="modules" class="mx-auto mt-16 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <flux:heading level="2" class="!text-2xl">Módulos actuales</flux:heading>
                <flux:text>Base lista para añadir Employees, Scheduling, Operations… sin reestructurar.</flux:text>
            </div>
            <flux:badge color="zinc">2 activos · N escalables</flux:badge>
        </div>

        <div class="mt-6 grid gap-4 lg:grid-cols-2">
            <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
                <div class="border-b border-zinc-200 px-6 py-4 dark:border-zinc-700">
                    <flux:heading level="3" size="sm">CoreModule</flux:heading>
                    <flux:text class="!text-sm">Núcleo compartido y bootstrapping</flux:text>
                </div>
                <div class="space-y-3 p-6 text-sm">
                    <flux:text>Provee servicios base y el <code class="rounded bg-zinc-100 px-1 py-0.5 text-xs dark:bg-zinc-800">CoreModuleServiceProvider</code> registrado en <code class="text-xs">bootstrap/providers.php</code>.</flux:text>
                    <div class="flex flex-wrap gap-1.5">
                        <flux:badge size="sm" color="zinc">Providers</flux:badge>
                        <flux:badge size="sm" color="zinc">Support</flux:badge>
                        <flux:badge size="sm" color="zinc">Actions</flux:badge>
                    </div>
                    <div class="rounded-lg bg-zinc-50 p-3 font-mono text-xs dark:bg-zinc-800">app/Modules/CoreModule/Providers/CoreModuleServiceProvider.php</div>
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
                <div class="border-b border-zinc-200 px-6 py-4 dark:border-zinc-700">
                    <flux:heading level="3" size="sm">UserModule</flux:heading>
                    <flux:text class="!text-sm">Identidad, permisos y UI reutilizable</flux:text>
                </div>
                <div class="space-y-3 p-6 text-sm">
                    <flux:text>Modelo en <code class="rounded bg-zinc-100 px-1 py-0.5 text-xs dark:bg-zinc-800">App\Modules\UserModule\Models\User</code>, factory en <code class="text-xs">database/factories</code>, 10 componentes Flux listos (Card, Callout, TableList…).</flux:text>
                    <div class="flex flex-wrap gap-1.5">
                        <flux:badge size="sm" color="zinc">Fortify</flux:badge>
                        <flux:badge size="sm" color="zinc">Spatie Permission</flux:badge>
                        <flux:badge size="sm" color="zinc">Livewire</flux:badge>
                    </div>
                    <div class="rounded-lg bg-zinc-50 p-3 font-mono text-xs dark:bg-zinc-800">app/Modules/UserModule/Livewire/Components/</div>
                </div>
            </div>
        </div>

        <div class="mt-4 rounded-xl border border-dashed border-zinc-300 bg-zinc-50 p-4 text-sm dark:border-zinc-700 dark:bg-zinc-900/50">
            <span class="font-semibold">¿Nuevo módulo?</span>
            <span class="text-zinc-600 dark:text-zinc-400"> Crea `app/Modules/InvoicingModule` y regístralo en `bootstrap/providers.php`. Nada de auto-discovery. Consulta `README.md` y `AGENTS.md` para convenciones.</span>
        </div>
    </section>

    {{-- Stack --}}
    <section id="stack" class="mx-auto mt-16 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900 sm:p-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <flux:heading level="2" class="!text-xl">Stack verificado</flux:heading>
                <flux:text class="!text-xs">PHP ^8.3 (CI 8.4) · Node 22 · Vite Plus</flux:text>
            </div>
            <flux:separator class="my-6" />
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Backend</div>
                    <ul class="mt-2 space-y-1 text-sm text-zinc-700 dark:text-zinc-300">
                        <li>Laravel 13 · Fortify · Sanctum</li>
                        <li>Horizon · Pulse · Spatie Data/Media/Permission</li>
                        <li>predis · dompdf · chisel</li>
                    </ul>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Frontend</div>
                    <ul class="mt-2 space-y-1 text-sm text-zinc-700 dark:text-zinc-300">
                        <li>Livewire 4 + Flux UI 2</li>
                        <li>Tailwind 4 + Vite Plus</li>
                        <li>Passkeys (@laravel/passkeys)</li>
                    </ul>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Calidad</div>
                    <ul class="mt-2 space-y-1 text-sm text-zinc-700 dark:text-zinc-300">
                        <li>Pest 5 · Pint · Larastan lvl 7</li>
                        <li>composer test · ci:check en GitHub Actions</li>
                        <li>SQLite :memory: para tests</li>
                    </ul>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Comandos</div>
                    <div class="mt-2 space-y-2 font-mono text-xs">
                        <div class="rounded bg-zinc-900 px-3 py-2 text-zinc-100 dark:bg-zinc-800">composer setup</div>
                        <div class="rounded bg-zinc-900 px-3 py-2 text-zinc-100 dark:bg-zinc-800">composer dev</div>
                        <div class="rounded bg-zinc-900 px-3 py-2 text-zinc-100 dark:bg-zinc-800">composer test</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="mx-auto mt-16 max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-zinc-900 px-6 py-10 text-white dark:bg-white dark:text-zinc-900 sm:px-10 sm:py-12">
            <div class="grid items-center gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <flux:heading level="2" class="!text-2xl !text-white dark:!text-zinc-900">Listo para construir tu siguiente módulo</flux:heading>
                    <flux:text class="mt-2 !text-zinc-300 dark:!text-zinc-600">Identifica el módulo propietario, define el caso de uso, implementa la Action y añade tests. Revisa `AGENTS.md` antes de empezar.</flux:text>
                </div>
                <div class="flex flex-wrap gap-3 lg:justify-end">
                    @auth
                        <flux:button href="{{ route('dashboard') }}" wire:navigate variant="primary" class="!bg-white !text-zinc-900 hover:!bg-zinc-100 dark:!bg-zinc-900 dark:!text-white">
                            Ir al dashboard
                        </flux:button>
                    @else
                        <flux:button href="{{ route('register') }}" wire:navigate variant="primary" class="!bg-white !text-zinc-900 hover:!bg-zinc-100 dark:!bg-zinc-900 dark:!text-white">
                            Crear cuenta gratis
                        </flux:button>
                        <flux:button href="{{ route('login') }}" wire:navigate variant="ghost" class="!text-white hover:!bg-white/10 dark:!text-zinc-900 dark:hover:!bg-zinc-900/10">
                            Iniciar sesión
                        </flux:button>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-zinc-200 dark:border-zinc-800">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-8 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <div class="flex items-center gap-2 text-sm text-zinc-500">
                <x-app-logo-icon class="size-5 text-zinc-900 dark:text-white" />
                <span class="font-medium text-zinc-900 dark:text-white">{{ config('app.name', 'CS Syncro') }}</span>
                <span>· Monolito modular en Laravel</span>
            </div>
            <div class="flex flex-wrap items-center gap-4 text-sm">
                <a href="https://github.com/laravel/livewire-starter-kit" target="_blank" class="inline-flex items-center gap-1.5 text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">
                    <flux:icon.folder-git-2 class="size-4" /> Repository
                </a>
                <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank" class="inline-flex items-center gap-1.5 text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">
                    <flux:icon.book-open-text class="size-4" /> Docs
                </a>
                <span class="text-xs text-zinc-400">{{ config('app.name', 'Laravel') }} · {{ date('Y') }}</span>
            </div>
        </div>
    </footer>

</x-layouts::app.simple>
