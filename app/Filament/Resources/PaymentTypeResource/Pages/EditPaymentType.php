<?php

namespace App\Filament\Resources\PaymentTypeResource\Pages;

use App\Filament\Actions\CopyLocaleFieldsAction;
use App\Filament\Resources\PaymentTypeResource;
use App\Traits\Translations\TranslatableEditView;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentType extends EditRecord
{
    use TranslatableEditView;

    protected static string $resource = PaymentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            CopyLocaleFieldsAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
