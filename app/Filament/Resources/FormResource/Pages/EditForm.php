<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Actions\CopyLocaleFieldsAction;
use App\Filament\Resources\FormResource;
use App\Traits\Translations\TranslatableEditView;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;
use Illuminate\Support\Arr;

class EditForm extends EditRecord
{
    use TranslatableEditView;

    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            CopyLocaleFieldsAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
