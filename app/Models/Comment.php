<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'reader_id',
        'content',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $hidden = [
        'post_id',
        'reader_id',
        'created_at',
        'updated_at',
    ];
    
    public function post()
    {
        return $this->belongsTo(Post::class);  
    }
    public function reader()
    {
        return $this->belongsTo(Reader::class);
    }
}
