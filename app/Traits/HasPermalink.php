<?php

namespace App\Traits;

use App\Services\LocaleService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasPermalink
{
    public function permalink() : Attribute {
        return Attribute::make(
            get: fn(array $attributes) => LocaleService::getLocalizedRoutePathByName(name: "post", changeToLocale: $attributes['locale_scope']?->value, parameters: ['post' => $attributes['slug']]),
        );
    }
}
