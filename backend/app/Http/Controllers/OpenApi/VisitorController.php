<?php

declare(strict_types=1);

namespace App\Http\Controllers\OpenApi;


use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\VisitorResource;
use App\Actions\Visitors\CreateVisitorAction;

final class VisitorController extends Controller
{
    private $createVisitorAction;

    public function __construct(
        CreateVisitorAction $createVisitorAction
    ) {
        $this->createVisitorAction = $createVisitorAction;
    }

    public function createVisitor(): ApiResponse
    {
        $response = $this->createVisitorAction->execute();

        return ApiResponse::success(new VisitorResource($response->token()))->setStatusCode(201);
    }
}
