<div>
    <form wire:submit="save" class="space-y-4">
        <flux:field>
            <flux:label>Título</flux:label>
            <flux:input wire:model="title" placeholder="Ej: Preparar reporte semanal" />
            <flux:error name="title" />
        </flux:field>

        <flux:field>
            <flux:label>Descripción</flux:label>
            <flux:textarea wire:model="description" placeholder="Detalles opcionales..." rows="3" />
            <flux:error name="description" />
        </flux:field>

        <flux:field>
            <flux:label>Estado</flux:label>
            <flux:select wire:model="status" placeholder="Selecciona estado">
                <flux:select.option value="pending">Pendiente</flux:select.option>
                <flux:select.option value="in_progress">En progreso</flux:select.option>
                <flux:select.option value="done">Completada</flux:select.option>
            </flux:select>
            <flux:error name="status" />
        </flux:field>

        <div class="flex justify-end gap-2">
            <flux:button type="submit" variant="primary">
                {{ $task ? 'Actualizar' : 'Crear' }} tarea
            </flux:button>
        </div>
    </form>
</div>
