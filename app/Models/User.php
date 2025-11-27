<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Model relations ---------------------------------------------------
    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id', 'id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    // Model methods ---------------------------------------------------
    public function getImageUrl(string $conversion = 'preview'): string
    {
        if($this->media->first()) {
            return $this->media->first()->getUrl($conversion);
        } else {
            return asset('img/user-placeholders/profile.avif');
        }
    }

    // Medialibrary conversions ---------------------------------------------------
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Crop, 50, 50)
            ->nonQueued();

        $this
            ->addMediaConversion('profile')
            ->fit(Fit::Crop, 200, 200)
            ->nonQueued();
    }
}
