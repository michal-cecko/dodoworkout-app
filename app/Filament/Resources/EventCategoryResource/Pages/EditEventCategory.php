<?php

namespace App\Filament\Resources\EventCategoryResource\Pages;

use App\Filament\Resources\EventCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditEventCategory extends EditRecord
{
    use Translatable;

    protected static string $resource = EventCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
