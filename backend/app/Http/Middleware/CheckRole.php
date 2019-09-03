<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

final class CheckRole
{
    public function handle($request, Closure $next)
    {
        $roles = $this->getRequiredRoleForRoute($request->route());
        if(auth()->user()->isWebsiteOwner($request->id) || !$roles)
        {
            return $next($request);
        }
        return response([
            'error' => [
                'message' => 'You do not have rights to access this resource.'
            ]
        ], 401);
    }
    private function getRequiredRoleForRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}