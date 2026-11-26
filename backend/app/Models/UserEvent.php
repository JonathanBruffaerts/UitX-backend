<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'event_id', 'is_going', 'is_saved', 'reminder_sent'])]
class UserEvent extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(EventCache::class, 'event_id', 'event_id');
    }

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'is_going' => 'boolean',
            'is_saved' => 'boolean',
            'reminder_sent' => 'boolean',
            'updated_at' => 'datetime',
        ];
    }
}
