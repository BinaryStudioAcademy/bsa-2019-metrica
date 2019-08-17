<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Page extends Model
{
    protected $fillable = [
        'name',
        'url',
        'previews',
        'website_id',
    ];

    protected $with = ['website'];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
