<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'role',
        'status',
        'phone',
        'address',
        'bio',
        'avatar',
        'last_seen'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_seen' => 'datetime',
    ];

  public function isOnline(): bool
{
    if ($this->status !== 'active') {
        return false;
    }
    return $this->last_seen && $this->last_seen->gt(now()->subMinutes(5));
}
}