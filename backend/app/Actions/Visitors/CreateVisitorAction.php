<?php


namespace App\Actions\Visitors;

use App\Repositories\Contracts\VisitorRepository;
use App\Repositories\Contracts\WebsiteRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Actions\Visitor\CreateVisitorRequest;
use App\Actions\Visitors\CreateVisitorResponse;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Entities\Visitor;
use App\Exceptions\WebsiteDomainNotValidException;

class CreateVisitorAction
{
    private $visitorRepository;
    private $websiteRepository;

    public function __construct(
        VisitorRepository $visitorRepository,
        WebsiteRepository $websiteRepository
    ) {
        $this->visitorRepository = $visitorRepository;
        $this->websiteRepository = $websiteRepository;
    }

    public function execute(CreateVisitorRequest $request)
    {
        $websiteId = $this->websiteRepository
            ->getByTrackNumber($request->trackNumber())->id;

        $visitorInstance = Visitor::make([
            'website_id' => $websiteId,
            'visitor_type'=> ''
        ]);

        $visitorId = $this->visitorRepository
                          ->save($visitorInstance)
                          ->id;

        $payload = JWTFactory::customClaims([
            'sub' => env('API_ID'),
            'exp' =>Carbon::now()->addYear(),
            'visitor_id' => $visitorId
        ])->make();

        $token = JWTAuth::encode($payload);

        return new CreateVisitorResponse($token);
    }
}
