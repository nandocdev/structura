<x-layouts::app title="Tareas">
    <div class="mx-auto max-w-5xl space-y-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Tareas</flux:heading>
                <flux:text class="mt-1">Ejemplo CRUD del monolito modular — TaskModule como plantilla copiable.</flux:text>
            </div>
            <flux:badge color="zinc">TaskModule · plantilla P0</flux:badge>
        </div>

        <livewire:task-module.task-list />
    </div>
</x-layouts::app>
