<?php

namespace App\Filament\Actions;

namespace App\Filament\Actions;

use App\Contracts\CanCopyLocaleMutations;
use App\Enum\Locale;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class CopyLocaleFieldsAction extends Action
{
    public static function make(?string $name = 'copy_locale'): static
    {
        return parent::make($name)
            ->label('Kopírovať jazykovú mutáciu')
            ->form([
                Select::make('source')
                    ->label('Aký mutáciu chcete skopírovať?')
                    ->options([
                        'sk' => 'SK => EN',
                        'en' => 'EN => SK',
                    ])
                    ->required(),
            ])
            ->color("warning")
            ->modalSubmitActionLabel("Skopírovať")
            ->action(function (array $data, CanCopyLocaleMutations $record): void {
                if ($data['source'] === 'sk') {
                    $record->copyMutation(sourceLocale: Locale::SK, targetLocale: Locale::EN);
                } else {
                    $record->copyMutation(sourceLocale: Locale::EN, targetLocale: Locale::SK);
                }
                $record->save();
                Notification::make()
                    ->title('Mutácia bola úspešne skopírovaná.')
                    ->success()
                    ->send();
            });
    }
}
