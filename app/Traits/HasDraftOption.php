<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasDraftOption
{
    public function scopePublished(Builder $query): Builder
    {
        return $query->where("is_draft", false);
    }
}
