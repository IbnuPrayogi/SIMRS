<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        $user = $request->user();

        if ($user && $user->role === $role) {
            return $next($request);

        }

        abort(403, 'Unauthorized');
    }
}
