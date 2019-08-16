<?php

namespace App\Repositories;

use App\Actions\Visitors\GetNewChartVisitorsByDateRangeRequest;
use App\Repositories\Contracts\ChartVisitorsRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EloquentChartVisitorsRepository implements ChartVisitorsRepository
{
    public function getNewVisitorsByDate(GetNewChartVisitorsByDateRangeRequest $request): Collection
    {
        $subQueryFirst = "SELECT id FROM websites where user_id = :user_id";
        $subQuerySecond = "SELECT visitors.*, ( " .$this->getPeriod('created_at',$request->getPeriod()) .") as period
                             FROM \"visitors\" WHERE
                                      created_at >= :startData and created_at <= :endData and website_id = ($subQueryFirst)";
        $query = DB::raw("SELECT COUNT(*), period from ($subQuerySecond) as periods group by period");
        $response = DB::select((string)$query, [
            'startData' => Carbon::createFromTimestampUTC($request->getStartDate())->toDateTimeString(),
            'endData' => Carbon::createFromTimestampUTC($request->getEndDate())->toDateTimeString(),
            'user_id' => Auth::user()->id
        ]);
        return collect($response);
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
                    $this->toNumeric($this->toTimestamp($columnName)) . " %" .$period.")";
    }
}
