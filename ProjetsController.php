<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // Lister tous les projets de l'enseignant
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        return response()->json($projects, 200);
    }

    // Créer un nouveau projet
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'keywords' => 'nullable|string',
            'technologies' => 'nullable|string',
        ]);

        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'technologies' => $request->technologies,
        ]);

        return response()->json(['message' => 'Project created successfully', 'project' => $project], 201);
    }

    // Mettre à jour un projet
    public function update(Request $request, $id)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'keywords' => 'nullable|string',
            'technologies' => 'nullable|string',
            'status' => 'in:open,in_progress,completed',
        ]);

        $project->update($request->all());

        return response()->json(['message' => 'Project updated successfully', 'project' => $project], 200);
    }

    // Supprimer un projet
    public function destroy($id)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], 200);
    }

    // Afficher un projet spécifique
    public function show($id)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($project, 200);
    }
}
