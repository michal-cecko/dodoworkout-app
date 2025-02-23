<?php

namespace App\Filament\Resources\ShippingTypeResource\Pages;

use App\Filament\Actions\CopyLocaleFieldsAction;
use App\Filament\Resources\ShippingTypeResource;
use App\Traits\Translations\TranslatableEditView;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShippingType extends EditRecord
{
    use TranslatableEditView;

    protected static string $resource = ShippingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            CopyLocaleFieldsAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
