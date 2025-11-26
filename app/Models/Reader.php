<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Reader extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'bio',
        'phone',
        'status',
    ];
    
    protected $casts = [ 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'image' => 'string',
        'profile_picture' => 'string',
        'bio' => 'string',
        'phone' => 'string',
        'status' => 'string',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'image',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
