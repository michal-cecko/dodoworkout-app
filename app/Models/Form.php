<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Form extends Model
{
    use HasTranslations, HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => 'array',
    ];

    protected $translatable = [
        'name',
        'fields'
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class);
    }
}
