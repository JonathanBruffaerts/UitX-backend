<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

#[Fillable(['requester_id', 'addressee_id', 'status'])]
class Friendship extends Model
{
    protected static function booted(): void
    {
        static::saving(function (Friendship $friendship) {
            if ((int) $friendship->requester_id === (int) $friendship->addressee_id) {
                throw new InvalidArgumentException('A user cannot add themselves as a friend.');
            }
        });
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function addressee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'addressee_id');
    }

    protected function casts(): array
    {
        return [
            'requester_id' => 'integer',
            'addressee_id' => 'integer',
        ];
    }
}
