<?php

namespace App\Filament\Resources\ShippingTypeResource\Pages;

use App\Filament\Resources\ShippingTypeResource;
use App\Traits\Translations\TranslatableListView;
use Filament\Actions;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords;

class ListShippingTypes extends ListRecords
{
    use TranslatableListView;

    protected static string $resource = ShippingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
