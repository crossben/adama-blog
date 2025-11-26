<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webtv extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'categorie_id',
        'tags',
        'title',
        'slug',
        'description',
        'image',
        'status',
        'image',
        'url',
        'status'
    ]; 

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'image' => 'string',
        'category' => 'string',
        'tags' => 'string',
    ];
    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
        'image',
        'category',
        'image'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    
}