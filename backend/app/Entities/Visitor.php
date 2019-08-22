<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

final class Visitor extends Model
{
    protected $fillable = [
        'visitor_type',
        'website_id',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function scopeForUserWebsite(Builder $query): Builder
    {
        return $query->whereWebsiteId(Auth::user()->website->id);
    }

    public function scopeWhereCreatedAtBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }
}
