<?php


namespace App\Actions\Visitors;

use App\DataTransformer\ButtonValue;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Support\Facades\Auth;
use App\Actions\Visitors\CreateVisitorResponse;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateVisitorAction
{
    private $repository;

    public function __construct(VisitorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        $websiteId = Auth::user()->website->id;

        $visitorId = $this->repository->save($websiteId)->id;

        $payload = JWTFactory::customClaims([
            'sub' => env('API_ID'),
            'visitor_id' => $visitorId
        ])->make();

        $token = JWTAuth::encode($payload);

        return new CreateVisitorResponse($token);
    }
}
