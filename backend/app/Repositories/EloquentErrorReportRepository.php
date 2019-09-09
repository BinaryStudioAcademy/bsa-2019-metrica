<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\ErrorReport\TableErrorReport;
use App\Entities\Error;
use App\Repositories\Contracts\ErrorReport\ErrorReportRepository;
use Illuminate\Support\Collection;
use App\Utils\DatePeriod;
use Illuminate\Support\Facades\DB;

final class EloquentErrorReportRepository implements ErrorReportRepository
{
    public function save(Error $error): Error
    {
        $error->save();
        return $error;
    }

    public function getErrorItemsGroupByPage(int $websiteId, DatePeriod $datePeriod): Collection
    {
        $errors = Error::ForWebsite($websiteId)
            ->join('pages', 'pages.id', '=', 'errors.page_id')
            ->select(DB::raw('pages.url as parameter_value, errors.message, errors.stack_trace, count(errors.id) as count_errors'))
            ->whereBetween('errors.created_at', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy(['pages.id', 'errors.message', 'errors.stack_trace'])
            ->get();

        return $this->mapToTableValues($errors, 'page');
    }

    private function mapToTableValues(Collection $errors, string $parameter)
    {
        return $errors->map(function($item) use ($parameter) {
            return new TableErrorReport(
                $parameter,
                $item->parameter_value,
                strval($item->count_errors),
                $item->message,
                $item->stack_trace
            );
        });
    }
}
