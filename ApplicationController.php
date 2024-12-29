<?php
namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    // Consulter tous les étudiants
    public function getAllStudents()
    {
        $students = Student::with('user')->get();
        return response()->json($students, 200);
    }

    // Consulter les candidatures d'un projet
    public function getApplicationsByProject($projectId)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($projectId);
        $applications = $project->applications()->with('student.user')->get();

        return response()->json($applications, 200);
    }

    // Accepter une candidature
    public function acceptApplication($id)
    {
        $application = Application::findOrFail($id);
        $application->status = 'accepted';
        $application->save();

        return response()->json(['message' => 'Application accepted successfully'], 200);
    }

    // Rejeter une candidature
    public function rejectApplication($id)
    {
        $application = Application::findOrFail($id);
        $application->status = 'rejected';
        $application->save();

        return response()->json(['message' => 'Application rejected successfully'], 200);
    }
}
