<?php

namespace App\Filament\Resources\CommonResource;

use App\Filament\Trait\UseResourceTable;
use App\Models\PostTag;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

abstract class CommonResource extends Resource
{
    use UseResourceTable, Translatable;

    public static function getCreatedAtField(): Placeholder
    {
        return Placeholder::make('created')->label("Vytvorené dňa")->visibleOn("edit")->content(fn (?Model $record): string => $record?->created_at?->toFormattedDateString());
    }

    public static function getUpdatedAtField(): Placeholder
    {
        return Placeholder::make('updated')->label("Posledná úprava")->visibleOn("edit")->content(fn (?Model $record): string => $record?->updated_at?->diffForHumans());
    }
}
