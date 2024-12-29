<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Project;
use App\Models\Application;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Events\NotificationEvent;

class TeacherController extends Controller
{ 
    public function getProfile()
    {
        return response()->json(auth()->user());
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'string|max:255',
            'specialization' => 'string|max:255',
            'phone' => 'string|max:15',
        ]);

        auth()->user()->update($request->only('name', 'specialization', 'phone'));

        return response()->json(['message' => 'Profile updated successfully'], 200);
    }


public function sendNotification($userId, $message)
{
    // Créez une notification avec un ID utilisateur
    $notification = [
        'user_id' => $userId,  // ID de l'utilisateur qui recevra la notification
        'message' => $message,
    ];

    // Diffuse l'événement
    event(new NotificationEvent($notification));
}
public function receiveApplication($projectId, $studentId)
{
    // Logique pour gérer la candidature du projet

    // Envoyer la notification
    $teacherId = Project::find($projectId)->teacher_id;
    $message = "Nouvelle candidature reçue pour votre projet.";

    $this->sendNotification($teacherId, $message);
}
 // Accéder au tableau de bord de l'enseignant
 public function dashboard(Request $request)
 {
     $user = auth()->user(); // L'utilisateur authentifié (enseignant)

     // Nombre de projets créés par l'enseignant
     $projects = Project::where('teacher_id', $user->id)->get();
     $totalProjects = $projects->count();

     // Statut des projets
     $openProjects = $projects->where('status', 'open')->count();
     $inProgressProjects = $projects->where('status', 'in_progress')->count();
     $completedProjects = $projects->where('status', 'completed')->count();

     // Candidatures
     $applications = Application::whereIn('project_id', $projects->pluck('id'))->get();
     $pendingApplications = $applications->where('status', 'pending')->count();
     $acceptedApplications = $applications->where('status', 'accepted')->count();
     $rejectedApplications = $applications->where('status', 'rejected')->count();

     // Notifications récentes
     $notifications = Notification::where('user_id', $user->id)
         ->orderBy('created_at', 'desc')
         ->take(5)
         ->get();

     return response()->json([
         'total_projects' => $totalProjects,
         'open_projects' => $openProjects,
         'in_progress_projects' => $inProgressProjects,
         'completed_projects' => $completedProjects,
         'pending_applications' => $pendingApplications,
         'accepted_applications' => $acceptedApplications,
         'rejected_applications' => $rejectedApplications,
         'notifications' => $notifications,
     ]);
 }

}






















