<?php

namespace App\Filament\Resources\ShippingTypeResource\Pages;

use App\Filament\Resources\ShippingTypeResource;
use App\Traits\Translations\TranslatableCreateView;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateShippingType extends CreateRecord
{
    use TranslatableCreateView;

    protected static string $resource = ShippingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
