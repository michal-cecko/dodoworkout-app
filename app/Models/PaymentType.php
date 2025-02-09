<?php

namespace App\Models;

use App\Traits\HasHidden;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasHidden;

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
