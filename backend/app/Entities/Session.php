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
        'language',
        'system_id',
    ];

    protected $with = ['visitor', 'page', 'system'];

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
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
}
