<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isKid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'User not logged in');
        }

        if ($user->role?->name === 'kid' || $user->role?->name === 'parent' || $user->role?->name === 'admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized: User type is ' . $user->role?->name);
    }
}
