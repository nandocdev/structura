<?php

namespace App\Modules\UserModule\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * TableList Component - Flux UI Table wrapper
 *
 * Proporciona una tabla reactiva con soporte para:
 * - Paginación
 * - Sorting (ordenamiento)
 * - Estados de carga
 * - Acciones por fila
 * - Responsive design
 *
 * @example
 * <livewire:user-module.components.table-list
 *     :rows="$users"
 *     :columns="[
 *         ['key' => 'name', 'label' => 'Name', 'sortable' => true],
 *         ['key' => 'email', 'label' => 'Email'],
 *         ['key' => 'role', 'label' => 'Role'],
 *     ]"
 * />
 */
class TableList extends Component
{
    use WithPagination;

    public array $rows = [];

    public array $columns = [];

    public ?string $sortBy = null;

    public string $sortDirection = 'asc';

    public int $perPage = 15;

    public ?string $emptyMessage = null;

    /**
     * Mount the component
     */
    public function mount(array $rows = [], array $columns = []): void
    {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->emptyMessage ??= __('No records found.');
    }

    /**
     * Handle sorting
     */
    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    /**
     * Emit event for row action (edit, delete, etc.)
     */
    #[On('table-row-action')]
    public function handleRowAction(int $rowId, string $action): void
    {
        $this->dispatch('row-action', ['id' => $rowId, 'action' => $action]);
    }

    public function render()
    {
        return view('livewire.user-module.components.table-list', [
            'rows' => $this->rows,
            'columns' => $this->columns,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
            'perPage' => $this->perPage,
            'emptyMessage' => $this->emptyMessage,
        ]);
    }
}
