<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_published' => 'bool',
        ];
    }

    // Model relations ---------------
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Model methods ------------------
    public function canBeManagedBy(?User $user)
    {
        if(!$user) {
            return false;
        }

        if($user->id === $this->author_id) {
            return true;
        }

        if($user->is_admin) {
            return true;
        }

        return false;
    }

}
