<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TeacherMidddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       


        if (Auth::check() && Auth::user()->role == 'teacher') {
            return $next($request);
        }
          // Rediriger si l'utilisateur n'est pas un enseignant
        return redirect('/')->with('error', 'Accès réservé aux enseignants.');
        }
}
