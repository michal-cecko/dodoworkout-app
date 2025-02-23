<?php

namespace App\Models;

use App\Contracts\CanCopyLocaleMutations;
use App\Contracts\Sluggable;
use App\Enum\Locale;
use App\Observers\SlugObserver;
use App\Traits\HasSlug;
use App\Traits\Translations\HasCopyLocaleMutations;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

#[ObservedBy(SlugObserver::class)]
class Form extends Model implements CanCopyLocaleMutations, Sluggable
{
    use HasTranslations, HasFactory, HasCopyLocaleMutations, HasSlug;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => 'array',
        'slug' => 'array'
    ];

    protected $translatable = [
        'name',
        'slug',
        'fields',
    ];

    public function slugFormat(?Locale $locale = null): string
    {
        $translations = $this->getTranslations("name");
        return Str::slug($translations[strtolower($locale->value)] ?? $translations[strtolower(config('app.fallback_locale') ?? null)]);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (Form $model) {
            if($model->getAttribute("fields") !== null) {
                unset($model->fields);
            }
        });
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class);
    }
}
