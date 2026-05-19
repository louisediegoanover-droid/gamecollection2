<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'subject', 
        'topic', 'message', 'ip_address', 'user_agent'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}