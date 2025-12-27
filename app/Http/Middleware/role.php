<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, String $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }
        return $next($request);
        if (Auth::check()) {
            $user = Auth::user();
            $user_role = $user->roles()->value('name');
            if ($user_role === $role) {
                return $next($request);
            }
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        
    }
}
