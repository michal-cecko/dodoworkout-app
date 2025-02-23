<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FormSubmissionField extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'form_submission_id',
        'form_field_id',
        'value',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public function formSubmission(): BelongsTo
    {
        return $this->belongsTo(FormSubmission::class);
    }

    public function formField(): BelongsTo
    {
        return $this->belongsTo(FormField::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media');
    }
}
