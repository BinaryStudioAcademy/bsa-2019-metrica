<?php

declare(strict_types=1);

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $domain
 * @property boolean $single_page
 * @property int $user_id
 * @property User $user
 * @property int $tracking_number
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
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
        return $this->belongsToMany(User::class)->withPivot(['role', 'permitted_menu']);
    }

    public function visits()
    {
        return $this->hasManyThrough(Visit::class, Page::class);
    }
}
