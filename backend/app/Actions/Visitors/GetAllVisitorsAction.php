<?php
declare(strict_types=1);
namespace App\Actions\Visitors;

use App\Repositories\Contracts\VisitorRepository;

final class GetAllVisitorsAction
{
    private $visitorRepository;
    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }
    public function execute(): GetAllVisitorsResponse
    {
        $visitors = $this->visitorRepository->all();
        return new GetAllVisitorsResponse($visitors);
    }
}