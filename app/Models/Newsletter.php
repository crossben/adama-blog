<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'is_subscribed',
        'language',
    ];

    protected $attributes = [
        'is_subscribed' => true,
        'language' => null,
    ];

    protected $casts = [
        'is_subscribed' => 'boolean',
        'language' => 'string',
    ];

}
