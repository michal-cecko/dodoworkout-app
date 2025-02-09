<?php

namespace App\Models;

use App\Traits\HasHidden;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ShippingType extends Model
{
    use HasTranslations, HasHidden;

    protected $fillable = [
        'label',
        'description',
        'price',
        'is_hidden',
        'icon',
    ];

    protected $casts = [
        'label' => 'array',
    ];

    protected $translatable = [
        'label',
    ];
}
