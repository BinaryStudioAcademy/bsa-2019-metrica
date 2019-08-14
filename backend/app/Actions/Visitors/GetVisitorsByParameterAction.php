<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\TableVisitorsRepository;
use http\Exception\InvalidArgumentException;

final class GetVisitorsByParameterAction
{
    private $tableVisitorRepository;

    public function __construct(TableVisitorsRepository $tableVisitorRepository)
    {
        $this->tableVisitorRepository = $tableVisitorRepository;
    }

    public function execute(GetVisitorsByParameterRequest $request): GetVisitorsByParameterResponse
    {
        switch ($request->parameter()) {
            case 'city':
                $visitors = $this->tableVisitorRepository
                    ->groupByCity(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'country':
                $visitors = $this->tableVisitorRepository
                    ->groupByCity(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'language':
                $visitors = $this->tableVisitorRepository
                    ->groupByCity(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'browser':
                $visitors = $this->tableVisitorRepository
                    ->groupByCity(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'operating_system':
                $visitors = $this->tableVisitorRepository
                    ->groupByCity(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'screen_Resolution':
                $visitors = $this->tableVisitorRepository
                    ->groupByCity(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            default:
                throw new InvalidArgumentException(sprintf('The parameter "%s" is not valid.', $request->parameter()));
        }



        return new GetVisitorsByParameterResponse($visitors);
    }
}

