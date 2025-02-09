<?php

namespace App\Models;

use App\Enum\FormFieldFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class FormField extends Model
{
    use HasTranslations;

    protected $fillable = [
        'form_id',
        'label',
        'min',
        'max',
        'format',
        'options',
        'help_text',
        'is_required',

        'min',
        'max',
        'min_select',
        'max_select',
        'min_number',
        'max_number',
        'min_date',
        'max_date',
        'min_time',
        'max_time',
    ];

    protected $casts = [
        'label' => 'array',
        'options' => 'array',
        'help_text' => 'array',
        'format' => FormFieldFormat::class
    ];

    protected $translatable = [
        'label',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (FormField $model) {
            if ($model->format === FormFieldFormat::NUMBER) {
                $model->min = is_numeric($model->min_number) ? $model->min_number : null;
                $model->max = is_numeric($model->max_number) ? $model->max_number : null;
            } elseif (in_array($model->format, [FormFieldFormat::DATE, FormFieldFormat::DATETIME])) {
                $model->min = is_numeric($model->min_date) ? $model->min_date : null;
                $model->max = is_numeric($model->max_date) ? $model->max_date : null;
            } elseif ($model->format === FormFieldFormat::TIME) {
                $model->min = is_numeric($model->min_time) ? $model->min_time : null;
                $model->max = is_numeric($model->max_time) ? $model->max_time : null;
            } elseif(in_array($model->format, [FormFieldFormat::SELECT, FormFieldFormat::CHECKBOX])) {
                $model->min = is_numeric($model->min_select) ? $model->min_select : null;
                $model->max = is_numeric($model->max_select) ? $model->max_select : null;

                dump($model);

                if($model->is_required) {
                    $model->min_select = 1;
                    $model->max_select = 1;
                } else {
                    $model->min_select = null;
                }

                dd($model);
            } else {
                $model->min = null;
                $model->max = null;
            }

            unset(
                $model->min_number,
                $model->max_number,
                $model->min_date,
                $model->max_date,
                $model->min_time,
                $model->max_time,
                $model->min_select,
                $model->max_select
            );
        });
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
