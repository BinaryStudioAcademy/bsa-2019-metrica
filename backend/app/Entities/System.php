<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class System
 * @package App\Entities
 * @property int $id
 * @property string $name
 * @property string $os
 * @property string $browser
 * @property string $device
 * @property int $resolution_width
 * @property int $resolution_height
 */
final class System extends Model
{
    protected $fillable = [
        'name',
        'os',
        'browser',
        'device',
        'resolution_width',
        'resolution_height'
    ];

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }
}
