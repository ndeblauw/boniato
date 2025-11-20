<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;
    use InteractsWithMedia;

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
