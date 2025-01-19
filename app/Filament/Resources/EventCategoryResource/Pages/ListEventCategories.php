<?php

namespace App\Filament\Resources\EventCategoryResource\Pages;

use App\Filament\Resources\EventCategoryResource;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListEventCategories extends ListRecords
{
    use Translatable;

    protected static string $resource = EventCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
