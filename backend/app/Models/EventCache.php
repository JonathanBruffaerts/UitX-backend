<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['event_id', 'title', 'location_name', 'address', 'city', 'start_date', 'latitude', 'longitude', 'payload', 'cached_at'])]
class EventCache extends Model
{
    protected $table = 'events_cache';

    protected $primaryKey = 'event_id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'payload' => 'array',
            'cached_at' => 'datetime',
        ];
    }
}
