<?php

namespace App\Models;

use App\Contracts\Sluggable;
use App\Contracts\Viewable;
use App\Enum\Locale;
use App\Observers\SlugObserver;
use App\Services\LocaleService;
use App\Traits\HasDraft;
use App\Traits\HasPermalink;
use App\Traits\HasSlug;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

#[ObservedBy(SlugObserver::class)]
class Event extends Model implements Sluggable, HasMedia, Viewable
{
    /**
     * @use HasFactory<EventFactory>
     */
    use HasTranslations, HasSlug, InteractsWithMedia, HasFactory, HasDraft, HasPermalink;

    protected string $frontendView = "event";

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
        'locale_scope',
        'vat_included',
        'form_id',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'title' => 'array',
        'content' => 'array',
        'excerpt' => 'array',
        'slug' => 'array',
        'address' => 'array',
        'locale_scope' => Locale::class,
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

    public function slugFormat(?Locale $locale = null): string
    {
        $translations = $this->getTranslations("title");
        return Str::slug($translations[$locale->value] ?? $translations[config('app.fallback_locale') ?? null]);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function isPublished() : Attribute
    {
        return Attribute::make(
            get: fn(array $attributes) => !$attributes['is_draft'],
        );
    }

    public function scopeLocale(Builder $query, Locale|string $locale): Builder
    {
        if(is_string($locale)) {
            $locale = Locale::from($locale);
        }

        return $query->where(function ($subquery) use ($locale) {
            $subquery->where('locale_scope', $locale)->orWhereNull('locale_scope');
        });
    }

    public function days() : Attribute
    {
        return Attribute::make(
            get: fn(array $attributes) => $attributes['end_at']?->diffInDays($attributes['start_at']) ?? null,
        );
    }

    public function participantsAvailable() : Attribute
    {
        #TODO calculate participants available
        return Attribute::make(
            get: fn(array $attributes) => $attributes['participants_count'],
        );
    }

    public function lastFewLeft() : Attribute {
        return Attribute::make(
            get: function(array $attributes) {
                if (!$attributes['participants_count']) {
                    return false;
                }

                return $attributes['participants_available'] <= ($attributes['participants_count'] * 0.2);
            },
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('content_media');
    }
}
