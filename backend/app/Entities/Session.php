<?php
declare(strict_types=1);

namespace App\Entities;

use App\Utils\DatePeriod;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

final class Session extends Model
{
    protected $fillable = [
        'start_session',
        'end_session',
        'visitor_id',
        'entrance_page_id',
        'language',
        'system_id',
    ];

    protected $dates = ['start_session', 'end_session'];

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'entrance_page_id');
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function visit(): HasOne
    {
        return $this->hasOne(Visit::class);
    }

    public function scopeInactive(Builder $query, DateTime $date): Builder
    {
        return $query->where('updated_at', '<', Carbon::instance($date)->subMinutes(30)->toDateTimeString());
    }

    public function scopeWhereDateBetween(Builder $query, DatePeriod $datePeriod): Builder
    {
        return $query->whereBetween('start_session', [$datePeriod->getStartDate(), $datePeriod->getEndDate()]);
    }

    public function scopeForWebsite(Builder $query, int $website_id): Builder
    {
        return $query->whereHas('page', function($query) use ($website_id) {
            $query->where('website_id', $website_id);
        });
    }

    public function scopeAvgSessionTime(Builder $query): Builder
    {
        return $query->select(
            DB::raw(
                'round(extract(epoch from (avg(sessions.updated_at - sessions.start_session)))) as avg_session_time'
            )
        );
    }

    public function scopeGroupByParameter(Builder $query, string $param): Builder
    {
        return $query->when($param === 'language', function (Builder $query) {
            return $query->addSelect('language as parameter_value')
                ->groupBy('language');
        })
            ->when(
                in_array($param, ['country', 'city']),
                function (Builder $query) use ($param) {
                    return $query->join('visits', 'sessions.id', '=', 'visits.session_id')
                        ->join('geo_positions', 'visits.geo_position_id', '=', 'geo_positions.id')
                        ->when($param === 'country', function (Builder $query) {
                            return $query->addSelect('country as parameter_value')
                                ->groupBy('country');
                        })
                        ->when($param === 'city', function (Builder $query) {
                            return $query->addSelect('city as parameter_value')
                                ->groupBy('city');
                        });
                })
            ->when(
                in_array($param, ['browser', 'operating_system', 'screen_resolution']),
                function (Builder $query) use ($param) {
                    return $query->join('systems', 'sessions.system_id', '=', 'systems.id')
                        ->when($param === 'browser', function (Builder $query) {
                            return $query->addSelect('browser as parameter_value')
                                ->groupBy('browser');
                        })
                        ->when($param === 'operating_system', function (Builder $query) {
                            return $query->addSelect('os as parameter_value')
                                ->groupBy('os');
                        })
                        ->when($param === 'screen_resolution', function (Builder $query) {
                            return $query->addSelect(
                                DB::raw('concat(resolution_width, \'x\', resolution_height) as parameter_value')
                            )
                                ->groupBy('parameter_value');
                        });
                });
    }

    public function scopeCalculateAvgSessionTimePercentage(Builder $query): Builder
    {
        return $query->addSelect(
            DB::raw(
                'round(extract(epoch from (max(sessions.updated_at) - min(sessions.start_session)))) as max_time_difference'
            )
        );
    }

    public function getAvgSessionTimePercentageAttribute()
    {
        return $this->avg_session_time / $this->max_time_difference * 100;
    }
}
