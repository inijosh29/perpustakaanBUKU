<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleMiddleware
{
    public function __invoke(Request $request, Closure $next, string $role)
    {
        $user = $request->user();

        if (!$user || $user->role !== $role) {
            throw new HttpException(403); // Forbidden
        }

        return $next($request);
    }
}
