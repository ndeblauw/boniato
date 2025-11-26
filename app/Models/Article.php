<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

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

    public function getImageUrl(string $conversion = 'preview'): string
    {
        if($this->media->first()) {
            return $this->media->first()->getUrl($conversion);
        } else {
            return asset('img/article-placeholders/placeholder-'.$conversion.'.jpg');
        }
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Crop, 320, 200)
            ->nonQueued();

        $this
            ->addMediaConversion('website')
            ->fit(Fit::Crop, 640, 400)
            ->nonQueued();
    }

}
