<?php

namespace App\Models;

use App\Contracts\Sluggable;
use App\Observers\SlugObserver;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

#[ObservedBy(SlugObserver::class)]
class Event extends Model implements Sluggable, HasMedia
{
    use HasTranslations, HasSlug, InteractsWithMedia, HasFactory;

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'slug',
        'category_id',
        'is_draft',
        'start_at',
        'end_at',
        'address',
        'latitude',
        'longitude',
        'participants_count',
        'price',
        'last_price',
        'has_location',
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'excerpt' => 'array',
        'slug' => 'array',
        'address' => 'array',
    ];

    protected $translatable = [
        'title',
        'content',
        'excerpt',
        'slug',
        'address',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            if (!$model->has_location) {
                $model->latitude = null;
                $model->longitude = null;
            }
        });
    }

    public function slugFormat(?string $locale = null): string
    {
        $translations = $this->getTranslations("title");
        return Str::slug($translations[$locale] ?? $translations[config('app.fallback_locale') ?? null]);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(EventCategory::class);
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
