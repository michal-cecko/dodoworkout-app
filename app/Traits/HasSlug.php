<?php

namespace App\Traits;

trait HasSlug
{
    public function slugColumn(): string
    {
        return "slug";
    }

    public function uniqueSlugQuery(string $slug, ?string $locale = null): bool
    {
        return static::query()->where("slug->" . $locale, $slug)->exists();
    }
}
