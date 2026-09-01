<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-1 gap-2">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar por título..." class="max-w-sm" />
            <flux:select wire:model.live="statusFilter" placeholder="Estado" class="w-40">
                <flux:select.option value="">Todos</flux:select.option>
                <flux:select.option value="pending">Pendiente</flux:select.option>
                <flux:select.option value="in_progress">En progreso</flux:select.option>
                <flux:select.option value="done">Completada</flux:select.option>
            </flux:select>
        </div>
        <flux:modal.trigger name="create-task">
            <flux:button variant="primary" icon="plus">Nueva tarea</flux:button>
        </flux:modal.trigger>
    </div>

    <flux:modal name="create-task" class="md:w-[480px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear tarea</flux:heading>
                <flux:text class="mt-2">Añade una nueva tarea a tu lista.</flux:text>
            </div>
            <livewire:task-module.task-form :key="'create-'.now()->timestamp" />
        </div>
    </flux:modal>

    <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium">Título</th>
                        <th class="px-4 py-2 text-left font-medium">Estado</th>
                        <th class="px-4 py-2 text-left font-medium">Creada</th>
                        <th class="px-4 py-2 text-right font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr class="border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ $task->title }}</div>
                                @if ($task->description)
                                    <div class="text-xs text-zinc-500">{{ Str::limit($task->description, 80) }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <flux:badge :color="$task->status->color()" size="sm">{{ $task->status->label() }}</flux:badge>
                            </td>
                            <td class="px-4 py-3 text-zinc-500">{{ $task->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3 text-right">
                                <flux:button wire:click="deleteTask({{ $task->id }})" wire:confirm="¿Eliminar esta tarea?" variant="ghost" size="sm" icon="trash">Eliminar</flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-zinc-500">No hay tareas. Crea la primera.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($tasks->hasPages())
            <div class="border-t border-zinc-200 p-4 dark:border-zinc-700">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</div>
