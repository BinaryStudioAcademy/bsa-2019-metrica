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
        'user_id',
        'tracking_number',
    ];

    protected $with = ['user'];

    public function getTrackingNumberAttribute($value)
    {
        return str_pad((string) $value, 8, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
