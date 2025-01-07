<?php

namespace App\Models;

use App\Contracts\Sluggable;
use App\Observers\SlugObserver;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

#[ObservedBy(SlugObserver::class)]
class Post extends Model implements Sluggable, HasMedia
{
    use HasTranslations, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'slug',
        'likes',
        'dislikes',
        'published_at',
        'is_draft',
    ];

    public $casts = [
        'title' => 'array',
        'content' => 'array',
        'excerpt' => 'array',
        'slug' => 'array',
    ];

    protected $translatable = [
        'title',
        'content',
        'excerpt',
        'slug',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->default_title = $model->getTranslation("title", config('app.fallback_locale'));
        });
    }

    public function slugFormat(?string $locale = null): string
    {
        $translations = $this->getTranslations("title");
        return Str::slug($translations[$locale] ?? $translations[config('app.fallback_locale') ?? null]);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(PostTag::class, "post_tag_post_pivot", "post_id", "tag_id");
    }

    public function getIsPublishedAttribute(): bool
    {
        return !$this->is_draft;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('content_media');
    }
}
