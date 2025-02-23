<?php

namespace App\Filament\Resources\PostTagResource\Pages;

use App\Filament\Resources\PostTagResource;
use App\Traits\Translations\TranslatableListView;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListPostTags extends ListRecords
{
    use TranslatableListView;

    protected static string $resource = PostTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
