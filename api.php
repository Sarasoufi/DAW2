<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);






//Routes protégées par l'authentification et le rôle
Route::middleware(['auth:sanctum'])->group(function () {

 Route::post('/choose-role', [AuthController::class, 'chooseRole']);
 // Envoyer un message
 Route::post('/messages', [MessageController::class, 'sendMessage']);

 // Récupérer l'historique des messages avec un utilisateur spécifique
 Route::get('/messages/conversation/{userId}', [MessageController::class, 'getConversation']);

 // Liste des conversations (derniers messages par utilisateur)
 Route::get('/messages/conversations', [MessageController::class, 'getConversations']);
// Route pour accéder au tableau de bord de l'enseignant
Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard']);





    // Routes spécifiques pour le rôle "teacher"
    Route::middleware('role:teacher')->group(function () {
        Route::get('/teacher/profile', [TeacherController::class, 'getProfile']);
        Route::put('/teacher/profile', [TeacherController::class, 'updateProfile']);
        Route::apiResource('/teacher/projects', ProjectController::class);
       // Liste des étudiants
    Route::get('/teacher/students', [ApplicationController::class, 'getAllStudents']);
    // Liste des candidatures pour un projet spécifique
    Route::get('/teacher/projects/{projectId}/applications', [ApplicationController::class, 'getApplicationsByProject']);
    // Accepter une candidature
    Route::post('/teacher/applications/{id}/accept', [ApplicationController::class, 'acceptApplication']);
    // Rejeter une candidature
    Route::post('/teacher/applications/{id}/reject', [ApplicationController::class, 'rejectApplication']);
    });
});














