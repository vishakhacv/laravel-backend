<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['creator', 'tasks'])->latest()->get();

        return response()->json($projects);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => $request->user()->id,
        ]);

        return response()->json($project->load('creator'), 201);
    }

    public function show(Project $project)
    {
        $project->load(['creator', 'tasks.assignee', 'tasks.creator']);

        return response()->json($project);
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        $project->update($request->only(['name', 'description']));

        return response()->json($project->load('creator'));
    }

    public function destroy(Project $project)
    {
        $project->tasks()->delete();
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }
}
