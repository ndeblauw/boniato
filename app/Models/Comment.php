<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $guarded = [];

    // Model relations --------
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function father()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'comment_id', 'id');
    }
}
