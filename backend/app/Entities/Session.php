<?php

declare(strict_types=1);

namespace App\Entities;

use App\Utils\DatePeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

final class Session extends Model
{
    protected $fillable = [
        'start_session',
        'end_session',
        'visitor_id',
        'entrance_page_id',
        'demographic_id',
        'system_id',
    ];

    protected $with = ['visitor', 'page', 'demographic', 'system'];

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function demographic(): BelongsTo
    {
        return $this->belongsTo(Demographic::class);
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function scopeInactive(Builder $query, string $date): Builder
    {
        return $query->where('updated_at', '<', Carbon::rawParse($date)->subMinutes(30)->toDateTimeString());
    }

    public function scopeWhereDateBetween(Builder $query, DatePeriod $datePeriod): Builder
    {
        return $query->whereBetween('start_session', [$datePeriod->getStartDate(), $datePeriod->getEndDate()]);
    }

    public function scopeAvgSessionsTime(Builder $query): Builder
    {
        return $query->select(
            DB::raw(
                'round(avg(unix_timestamp(timediff(sessions.updated_at, sessions.start_session)))) as time_difference'
            )
        );
    }

    public function scopeGroupByParameter(Builder $query, string $param): Builder
    {
        return $query->when($param === 'language', function (Builder $query) {
            return $query->groupBy('language');
        })
            ->when($param === 'country', function (Builder $query) {
                return $query->join(
                    'geo_positions',
                    'sessions.geo_position_id',
                    '=',
                    'geo_positions.id'
                )
                    ->addSelect('country as parameter_value')
                    ->groupBy('geo_positions.country');
            })
            ->when($param === 'city', function (Builder $query) {
                return $query->join(
                    'geo_positions',
                    'sessions.geo_position_id',
                    '=',
                    'geo_positions.id'
                )
                    ->addSelect('city as parameter_value')
                    ->groupBy('geo_positions.city');
            })
            ->when($param === 'browser', function (Builder $query) {
                return $query->join(
                    'systems',
                    'sessions.system_id',
                    '=',
                    'systems.id'
                )
                    ->addSelect('browser as parameter_value')
                    ->groupBy('browser');
            })
            ->when($param === 'operating_system', function (Builder $query) {
                return $query->join(
                    'systems',
                    'sessions.system_id',
                    '=',
                    'systems.id'
                )
                    ->addSelect('os as parameter_value')
                    ->groupBy('systems.os');
            })
            ->when($param === 'screen_resolution', function (Builder $query) {
                return $query->join(
                    'systems',
                    'sessions.system_id',
                    '=',
                    'systems.id'
                )
                    ->addSelect('resolution_width as parameter_value')
                    ->groupBy('systems.resolution_width', 'systems.resolution_height');
            });
    }
}
