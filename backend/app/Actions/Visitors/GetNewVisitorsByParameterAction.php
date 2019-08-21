<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\TableNewVisitorsRepository;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Auth;
use App\DataTransformer\TableValue;
use App\Actions\Visitors\GetNewVisitorsByParameterRequest;
use App\Actions\Visitors\GetVisitorsByParameterResponse;

final class GetNewVisitorsByParameterAction
{
    private $tableVisitorsRepository;

    public function __construct(TableNewVisitorsRepository $tableNewVisitorsRepository)
    {
        $this->tableNewVisitorsRepository = $tableNewVisitorsRepository;
    }

    public function execute(GetNewVisitorsByParameterRequest $request): GetVisitorsByParameterResponse
    {
        $websiteId = (int)auth()->user()->website->id;

        $parameter = $request->parameter();

        $visitors = $this->tableNewVisitorsRepository->groupVisitorsByParameter(
            $websiteId, $request->startDate(),  $request->endDate(), $request->parameter()
        )->map(function ($visitor) use ($parameter) {
            return new TableValue(
                $parameter,
                (string)$visitor->parameter_value,
                (string)$visitor->total,
                (float)$visitor->percentage
            );
        });

        return new GetVisitorsByParameterResponse($visitors);
    }
}

