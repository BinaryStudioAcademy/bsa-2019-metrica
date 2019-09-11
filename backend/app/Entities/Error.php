<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Utils\DatePeriod;

final class Error extends Model
{
    protected $fillable = [
        'message',
        'stack_trace',
        'visitor_id',
        'page_id',
    ];

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function scopeForWebsite(Builder $query, int $websiteId): Builder
    {
        return $query->whereHas('page', function(Builder $query) use ($websiteId) {
            $query->where('website_id', $websiteId);
        });
    }
}
