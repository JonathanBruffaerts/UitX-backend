<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['uitid_sub', 'email', 'password_hash', 'name', 'avatar_url', 'language'])]
#[Hidden(['password_hash'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password_hash' => 'hashed',
        ];
    }

    public function sentFriendships()
    {
        return $this->hasMany(Friendship::class, 'requester_id');
    }

    public function receivedFriendships()
    {
        return $this->hasMany(Friendship::class, 'addressee_id');
    }

    public function userEvents()
    {
        return $this->hasMany(UserEvent::class);
    }

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
