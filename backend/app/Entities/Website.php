<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

final class Website extends Model
{
    protected $fillable = [
        'name',
        'domain',
        'single_page',
        'tracking_number',
    ];

    public function getTrackingNumberAttribute($value)
    {
        return str_pad((string) $value, 8, '0', STR_PAD_LEFT);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
