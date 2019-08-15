<?php
declare(strict_types=1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class System extends Model
{
    protected $fillable = [
        'browser_id',
        'os_id',
        'screen_resolution',
    ];

    protected $with = ['browser', 'os'];

    public function browser(): BelongsTo
    {
        return $this->belongsTo(Browser::class);
    }

    public function os(): BelongsTo
    {
        return $this->belongsTo(Os::class);
    }
}
