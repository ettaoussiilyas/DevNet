<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('user')->get();
        return response()->json($projects);
    }

    public function store(Request $request): JsonResponse
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        $project = Project::create($validation);
        return response()->json($project, Response::HTTP_CREATED);
    }

    public function show(Project $project): JsonResponse
    {
        return response()->json($project->load('user'));
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'sometimes|required|string|unique:projects,descreption,' . $project->id,
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $project->update($validation);
        return response()->json($project);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
