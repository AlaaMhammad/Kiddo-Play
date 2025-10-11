<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[] ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            // إذا مش مسجل الدخول
            return redirect()->route('login');
        }

        // إذا كان الدور admin يسمح له بكل شيء
        if ($user->role->name === 'admin') {
            return $next($request);
        }

        // تحقق من الأدوار المسموح بها
        if (!in_array($user->role->name, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
