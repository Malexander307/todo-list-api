<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Filters\TaskFilter;
use App\Http\Requests\TaskCreateUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use http\Client\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TaskFilter $filter)
    {
        return TaskResource::collection(Task::filter($filter)->where('user_id', \Auth::id())->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskCreateUpdateRequest $request): TaskResource
    {
        return new TaskResource(Task::create($request->validationData()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): TaskResource
    {
        $this->authorize('view', $task);
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskCreateUpdateRequest $request, Task $task): TaskResource
    {
        $this->authorize('update', $task);
        $task->update($request->validated());
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): \Illuminate\Http\Response|bool
    {
        $this->authorize('delete', $task);

        if ($task->status === TaskStatus::DONE) {
            return \response(['message' => 'You can`t delete done task']);
        }

        return $task->delete();
    }

    public function markAsDone(Task $task): TaskResource|\Illuminate\Http\Response
    {
        $this->authorize('update', $task);

        if ($task->children()->where('status', TaskStatus::TODO)->first()) {
            return \response(['message' => 'You can`t mark as completed this task when it has uncompleted subtasks']);
        }

        $task->status = TaskStatus::DONE;
        $task->completed_at = now();
        $task->save();

        return new TaskResource($task);
    }
}
