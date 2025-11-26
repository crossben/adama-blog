<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime', 
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function event()
    {
        return $this->hasMany(Event::class);
    }

    public function webtv()
    {
        return $this->hasMany(Webtv::class);
    }
}
