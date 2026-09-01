<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Livewire;

use App\Modules\TaskModule\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

final class TaskList extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    #[On('task-saved')]
    public function refreshList(): void {}

    public function deleteTask(int $taskId): void
    {
        /** @var Task $task */
        $task = Task::query()->findOrFail($taskId);

        $this->authorize('delete', $task);

        $task->delete();

        $this->dispatch('task-saved');
    }

    public function render(): View
    {
        $this->authorize('viewAny', Task::class);

        $tasks = Task::query()
            ->forUser((int) auth()->id())
            ->when($this->search !== '', function ($query): void {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->when($this->statusFilter !== '', function ($query): void {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.task-module.task-list', [
            'tasks' => $tasks,
        ]);
    }
}
