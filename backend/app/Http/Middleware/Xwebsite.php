<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\Contracts\WebsiteRepository;
use App\Http\Response\ApiResponse;
use App\Exceptions\AppException;

class Xwebsite
{
    private $repository;

    public function __construct(WebsiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($request, Closure $next)
    {
        if (!($trackNumber = (int)$request->header('x-website'))) {
            return ApiResponse::error(new AppException('x-website header is required'));
        }

        return $next($request);
    }
}
