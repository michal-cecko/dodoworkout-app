<?php

namespace App\Misc;

use App\Models\Event;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSubmissionField;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $media->loadMissing("model");
        $x = DIRECTORY_SEPARATOR;
        $mod = $media->model;
        $modelClass = class_basename($mod);
        $modID = $mod->id;

        return match ($media->model_type) {
            MorphMap::getKeyByModel(Post::class) => "clanky{$x}{$mod->getTranslations("slug")['sk']}{$x}{$media->collection_name}{$x}",
            MorphMap::getKeyByModel(Event::class) => "eventy{$x}{$mod->getTranslations("slug")['sk']}{$x}{$media->collection_name}{$x}",
            MorphMap::getKeyByModel(Form::class) => "formulare{$x}{$mod->getTranslations("slug")['sk']}{$x}{$media->collection_name}{$x}",
            MorphMap::getKeyByModel(Order::class) => "objednavky{$x}{$mod->fullOrderNumber}{$x}{$media->collection_name}{$x}",
            MorphMap::getKeyByModel(FormSubmissionField::class) => "objednavky{$x}{$mod->formSubmission->order->fullOrderNumber}{$x}formulare{$x}{$mod->formSubmission->form->getTranslations("slug")['sk']}{$x}",

            default => "nezaradene{$x}" . Str::snake($modelClass) . "{$x}{$modID}{$x}{$media->collection_name}{$x}",
        };
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . '/responsive/';
    }
}
