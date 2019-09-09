<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Entities\Website;
use App\Exceptions\WebsiteNotFoundException;
use App\Exceptions\WrongAccessRightsException;
use Closure;

final class CheckRole
{
    public function handle($request, Closure $next)
    {
        $hasRoles = $this->getRequiredRoleForRoute($request->route());
        $website = Website::find((int)$request->id);
        $hasWebsite = $request->user()->hasWebsite((int)$request->id);
        if ($website === null) {
            throw new WebsiteNotFoundException();
        }
        if (!$hasWebsite && $hasRoles) {
            throw new WrongAccessRightsException();
        }

        return $next($request);
    }

    private function getRequiredRoleForRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}