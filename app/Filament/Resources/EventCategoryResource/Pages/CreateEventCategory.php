<?php

namespace App\Filament\Resources\EventCategoryResource\Pages;

use App\Filament\Resources\EventCategoryResource;
use Filament\Actions;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateEventCategory extends CreateRecord
{
    use Translatable;

    protected static string $resource = EventCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
