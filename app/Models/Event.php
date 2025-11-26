<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'categorie_id',
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'location',
        'image',
        'status',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'image' => 'string',
    ];
    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
        'image',
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
