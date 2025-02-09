<?php

namespace App\Filament\Actions;

namespace App\Filament\Actions;

use Filament\Actions\Action;

class FrontendViewAction extends Action
{
    public static function make(?string $name = 'view'): static
    {
        return parent::make($name)
            ->label('Náhľad')
            ->url(fn ($record): string => $record->permalink)
            ->openUrlInNewTab();
    }
}
