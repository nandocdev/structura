<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Livewire;

use App\Modules\TaskModule\Actions\CreateTask;
use App\Modules\TaskModule\Actions\UpdateTask;
use App\Modules\TaskModule\Data\CreateTaskData;
use App\Modules\TaskModule\Data\UpdateTaskData;
use App\Modules\TaskModule\Enums\TaskStatus;
use App\Modules\TaskModule\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;

final class TaskForm extends Component
{
    use AuthorizesRequests;

    public ?Task $task = null;

    public string $title = '';

    public ?string $description = null;

    public string $status = 'pending';

    public function mount(?Task $task = null): void
    {
        $this->task = $task;

        if ($task !== null) {
            $this->authorize('update', $task);

            $this->title = $task->title;
            $this->description = $task->description;
            $this->status = $task->status->value;
        } else {
            $this->authorize('create', Task::class);
        }
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'in:pending,in_progress,done'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $status = TaskStatus::from($this->status);

        if ($this->task !== null) {
            $this->authorize('update', $this->task);

            UpdateTask::run(
                $this->task,
                new UpdateTaskData(
                    title: $this->title,
                    description: $this->description,
                    status: $status,
                )
            );

            $this->dispatch('task-saved');

            return;
        }

        $this->authorize('create', Task::class);

        CreateTask::run(
            auth()->user(),
            new CreateTaskData(
                title: $this->title,
                description: $this->description,
                status: $status,
            )
        );

        $this->reset(['title', 'description']);
        $this->status = TaskStatus::Pending->value;

        $this->dispatch('task-saved');
    }

    public function render(): View
    {
        return view('livewire.task-module.task-form');
    }
}
