<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'slug',
        'image',
        'categorie_id',
        'status',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'image' => 'string',
        'category' => 'string',
        'tags' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
}
