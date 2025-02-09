<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasDraft
{
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where("is_draft", false);
    }
}
