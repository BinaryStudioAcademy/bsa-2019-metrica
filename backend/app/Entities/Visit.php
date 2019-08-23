<?php

declare(strict_types=1);

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Visit
 * @package App\Entities
 * @property int $id
 * @property Carbon $visit_time
 * @property string $ip_address
 * @property Session $session
 * @property int $session_id
 * @property Page $page
 * @property int $page_id
 * @property Visitor $visitor
 * @property int $visitor_id
 * @property GeoPosition $geo_position
 * @property int $geo_position_id
 */
final class Visit extends Model
{
    protected $fillable = [
        'visit_time',
        'ip_address',
        'session_id',
        'page_id',
        'visitor_id',
        'geo_position_id'
    ];

    protected $with = ['session', 'page', 'visitor', 'geo_position'];

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    public function geo_position(): BelongsTo
    {
        return $this->belongsTo(GeoPosition::class);
    }
}
