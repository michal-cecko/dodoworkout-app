<?php

namespace App\Filament\Resources\OrderResource\Actions;

use App\Models\Order;
use App\Services\OrderService;
use Filament\Actions\Action;

class ResendOrderCreatedEmailAction
{
    public static function make(): Action
    {
        return Action::make('resend_order_created')
            ->requiresConfirmation()
            ->icon('heroicon-s-envelope')
            ->label("Odoslať potvrdenie o objednávke")
            ->modalSubmitActionLabel("Odoslať potvrdenie")
            ->action(function (Order $record): void {
                OrderService::resendOrderCreatedNotification($record);
            })
            ->color("info");
    }
}
