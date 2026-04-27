<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'locale',
        'ip_address',
        'user_agent',
        'is_read',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'processed_at' => 'datetime',
        ];
    }
}
