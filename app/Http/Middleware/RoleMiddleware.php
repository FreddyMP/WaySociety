<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user->role) {
            return redirect()->route('register.role');
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
