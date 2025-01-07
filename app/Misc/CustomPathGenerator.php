<?php

namespace App\Misc;

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
            'post' => "blog{$x}posts{$x}{$mod->slug}{$x}{$media->collection_name}{$x}",

            default => "uncategorized{$x}" . Str::snake($modelClass) . "{$x}{$modID}{$x}{$media->collection_name}{$x}",
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
