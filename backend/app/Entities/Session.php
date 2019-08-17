<?php

declare(strict_types=1);

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function scopeWhereDateBetween(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('start_session', [$from, $to]);
    }

    public function scopeAvgSessionsTime(Builder $query): Builder
    {
        return $query->avg('updated_at - start_session');
    }

    public function scopeGroupByParameter(Builder $query, string $param): Builder
    {
        return $query->when($param === 'language', function (Builder $query) {
            return $query->groupBy('language');
        })
            ->when($param === 'country', function (Builder $query) {
                return $query->groupBy('geo_positions.country');
            })
            ->when($param === 'city', function (Builder $query) {
                return $query->groupBy('geo_positions.city');
            })
            ->when($param === 'browser', function (Builder $query) {
                return $query->groupBy('systems.browser');
            })
            ->when($param === 'operating_system', function (Builder $query) {
                return $query->groupBy('systems.os');
            })
            ->when($param === 'screen_resolution', function (Builder $query) {
                return $query->groupBy('systems.resolution_width', 'systems.resolution_height');
            });
    }
}
