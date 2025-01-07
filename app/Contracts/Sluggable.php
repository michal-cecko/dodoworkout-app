<?php

namespace App\Contracts;

interface Sluggable
{
    function slugColumn() : string;
    function slugFormat(?string $locale = null) : string;
    function uniqueSlugQuery(string $slug, ?string $locale = null) : ?object;
}
