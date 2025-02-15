<?php

namespace App\Models;

use App\Contracts\CanCopyLocaleMutations;
use App\Traits\Translations\HasCopyLocaleMutations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Form extends Model implements CanCopyLocaleMutations
{
    use HasTranslations, HasFactory, HasCopyLocaleMutations;

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

    protected static function boot()
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
