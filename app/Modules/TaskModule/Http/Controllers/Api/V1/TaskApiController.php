<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\TaskModule\Actions\CreateTask;
use App\Modules\TaskModule\Actions\DeleteTask;
use App\Modules\TaskModule\Actions\UpdateTask;
use App\Modules\TaskModule\Data\CreateTaskData;
use App\Modules\TaskModule\Data\UpdateTaskData;
use App\Modules\TaskModule\Enums\TaskStatus;
use App\Modules\TaskModule\Http\Requests\StoreTaskRequest;
use App\Modules\TaskModule\Http\Requests\UpdateTaskRequest;
use App\Modules\TaskModule\Http\Resources\TaskResource;
use App\Modules\TaskModule\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TaskApiController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Task::class);

        $tasks = Task::query()
            ->forUser((int) $request->user()->id)
            ->when($request->string('search')->isNotEmpty(), function ($q) use ($request): void {
                $q->where('title', 'like', '%'.$request->string('search').'%');
            })
            ->when($request->string('status')->isNotEmpty(), function ($q) use ($request): void {
                $q->where('status', $request->string('status')->toString());
            })
            ->latest()
            ->paginate((int) $request->integer('per_page', 15));

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $this->authorize('create', Task::class);

        $status = $request->has('status')
            ? TaskStatus::from((string) $request->string('status'))
            : TaskStatus::Pending;

        $task = CreateTask::run(
            $request->user(),
            new CreateTaskData(
                title: (string) $request->string('title'),
                description: $request->input('description'),
                status: $status,
            )
        );

        return (new TaskResource($task->load('user')))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Task $task): TaskResource
    {
        $this->authorize('view', $task);

        return new TaskResource($task->load('user'));
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $this->authorize('update', $task);

        $status = $request->has('status')
            ? TaskStatus::from((string) $request->string('status'))
            : null;

        $updated = UpdateTask::run(
            $task,
            new UpdateTaskData(
                title: $request->input('title'),
                description: $request->has('description') ? $request->input('description') : null,
                status: $status,
            )
        );

        return new TaskResource($updated->load('user'));
    }

    public function destroy(Request $request, Task $task): JsonResponse
    {
        $this->authorize('delete', $task);

        DeleteTask::run($task);

        return response()->json(null, 204);
    }
}
