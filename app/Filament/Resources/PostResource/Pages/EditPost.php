<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Actions\CopyLocaleFieldsAction;
use App\Filament\Actions\FrontendViewAction;
use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditPost extends EditRecord
{
    use Translatable;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            CopyLocaleFieldsAction::make(),
            FrontendViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
