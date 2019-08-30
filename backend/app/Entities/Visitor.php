<?php

declare(strict_types=1);

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * Class Visitor
 * @package App\Entities
 * @property int $id
 * @property string $visitor_type
 * @property int $website_id
 * @property Carbon $last_activity
 */
final class Visitor extends Model
{
    protected $fillable = [
        'visitor_type',
        'website_id',
        'last_activity'
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
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
