<?php

namespace App\Models;

use App\Contracts\CanCopyLocaleMutations;
use App\Contracts\Sluggable;
use App\Contracts\Viewable;
use App\Enum\Locale;
use App\Observers\SlugObserver;
use App\Services\LocaleService;
use App\Traits\HasDraft;
use App\Traits\HasSlug;
use App\Traits\Translations\HasCopyLocaleMutations;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

#[ObservedBy(SlugObserver::class)]
class Event extends Model implements Sluggable, HasMedia, Viewable, CanCopyLocaleMutations
{
    /**
     * @use HasFactory<EventFactory>
     */
    use HasTranslations, HasSlug, InteractsWithMedia, HasFactory, HasDraft, HasCopyLocaleMutations;

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
        return Str::slug($translations[strtolower($locale->value)] ?? $translations[strtolower(config('app.fallback_locale') ?? null)]);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function getDaysAttribute(): ?int
    {
        return $this->end_at?->diffInDays($this->start_at) ?? null;
    }

    public function getPermalinkAttribute(): string
    {
        return LocaleService::getLocalizedRoutePathByName(name: "event", changeToLocale: $this->locale_scope?->value, parameters: ['event' => $this->slug]);
    }

    public function getParticipantsAvailableAttribute(): ?int
    {
        #TODO calculate participants available
        return $this->participants_count;
    }

    public function getLastFewLeftAttribute(): bool
    {
        if (!$this->participants_count) {
            return false;
        }

        return $this->participants_available <= ($this->participants_count * 0.2);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('content_media');
    }
}
