<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Task::with(['project', 'assignee', 'creator']);

        // Members only see tasks assigned to them
        if (!$user->isAdmin()) {
            $query->where('assigned_to', $user->id);
        }

        $tasks = $query->latest()->get();

        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => Task::STATUS_TODO,
            'priority' => $request->priority ?? Task::PRIORITY_MEDIUM,
            'due_date' => $request->due_date,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => $request->user()->id,
        ]);

        return response()->json($task->load(['project', 'assignee', 'creator']), 201);
    }

    public function show(Task $task)
    {
        return response()->json($task->load(['project', 'assignee', 'creator']));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $user = $request->user();

        // Overdue tasks cannot be moved back to IN_PROGRESS
        if ($task->status === Task::STATUS_OVERDUE && $request->status === Task::STATUS_IN_PROGRESS) {
            return response()->json([
                'message' => 'Overdue tasks cannot be moved back to IN_PROGRESS.',
            ], 422);
        }

        // Only admin can close overdue tasks
        if ($task->status === Task::STATUS_OVERDUE && $request->status === Task::STATUS_DONE && !$user->isAdmin()) {
            return response()->json([
                'message' => 'Only admin can close overdue tasks.',
            ], 403);
        }

        // Members can only update status
        if ($user->isAdmin()) {
            $task->update($request->only([
                'title', 'description', 'status', 'priority',
                'due_date', 'project_id', 'assigned_to',
            ]));
        } else {
            $task->update($request->only(['status']));
        }

        return response()->json($task->load(['project', 'assignee', 'creator']));
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
