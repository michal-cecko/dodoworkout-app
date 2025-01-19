<?php

namespace App\Filament\Resources\PostTagResource\Pages;

use App\Filament\Resources\PostTagResource;
use App\Models\PostTag;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;

class EditPostTag extends EditRecord
{
    use Translatable;

    protected static string $resource = PostTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
