<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Providers;

use App\Modules\TaskModule\Livewire\TaskForm;
use App\Modules\TaskModule\Livewire\TaskList;
use App\Modules\TaskModule\Models\Task;
use App\Modules\TaskModule\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

final class TaskModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Task::class, TaskPolicy::class);

        Livewire::component('task-module.task-list', TaskList::class);
        Livewire::component('task-module.task-form', TaskForm::class);

        $this->loadViewsFrom(resource_path('views/modules/task'), 'task');
    }
}
