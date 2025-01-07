<?php

namespace App\Models;

use App\Contracts\Sluggable;
use App\Observers\SlugObserver;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

#[ObservedBy(SlugObserver::class)]
class PostTag extends Model implements Sluggable
{
    use HasTranslations, HasSlug;

    protected $fillable = [
        'name',
        'slug',
    ];

    public $casts = [
        'name' => 'array',
        'slug' => 'array',
    ];

    public array $translatable = [
        'name',
        'slug',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->default_name = $model->getTranslation("name", config('app.fallback_locale'));
        });
    }

    public function slugFormat(?string $locale = null): string
    {
        $translations = $this->getTranslations("name");
        return Str::slug($translations[$locale] ?? $translations[config('app.fallback_locale') ?? null]);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, "post_tag_post_pivot", "tag_id", "post_id");
    }
}
