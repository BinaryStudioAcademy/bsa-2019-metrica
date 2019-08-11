<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Visitor extends Model
{
    protected $fillable = [
        'visitor_type',
        'website_id',
    ];

    protected $with = ['website'];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }
}
