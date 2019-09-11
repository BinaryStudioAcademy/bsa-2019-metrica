<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\ErrorReport\TableErrorReport;
use App\DataTransformer\ErrorReport\ChartCountErrors;
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

    public function getErrorsCountByDate(
        string $startData,
        string $endData,
        string $interval,
        int $websiteId
    ): Collection {
        $subQuerySecond = "SELECT errors.*, 
        ( " . $this->getPeriod('errors.created_at', $interval) . ") as period FROM errors  
        LEFT JOIN pages  ON pages.id = errors.page_id
        WHERE errors.created_at >= :startData and errors.created_at <= :endData 
        AND website_id = :website_id";

        $query = DB::raw("SELECT COUNT(*), period from ($subQuerySecond) as periods group by period");

        $response = DB::select((string)$query, [
            'startData' => $startData,
            'endData' => $endData,
            'website_id' => $websiteId
        ]);

        return collect($response)->map(function ($item) {
            return new ChartCountErrors($item->period, $item->count);
        });
    }

    private function toTimestamp(string $columnName): string
    {
        return "extract(epoch from $columnName)";
    }

    private function toNumeric(string $expression): string
    {
        return $expression . "::numeric";
    }

    private function getPeriod(string $columnName, $period): string
    {
        return $this->toNumeric($this->toTimestamp($columnName)) . "-( " .
            $this->toNumeric($this->toTimestamp($columnName)) . " %" . $period . ")";
    }

    public function getErrorItemsGroupByPage(int $websiteId, DatePeriod $datePeriod): Collection
    {
        $errors = Error::ForWebsite($websiteId)
            ->join('pages', 'pages.id', '=', 'errors.page_id')
            ->select(DB::raw('pages.url as parameter_value, errors.message, errors.stack_trace, count(errors.id) as count_errors, max(errors.created_at) as max_created'))
            ->whereBetween('errors.created_at', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy(['pages.id', 'errors.message', 'errors.stack_trace'])
            ->orderBy('max_created', 'desc')
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
                $item->stack_trace,
                $item->max_created
            );
        });
    }
}
