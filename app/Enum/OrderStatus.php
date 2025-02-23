<?php

namespace App\Enum;

use App\Traits\Translations\TranslatableEnum;

enum OrderStatus: string
{
    use TranslatableEnum;

    case ACCEPTED = "ACCEPTED";
    case CANCELED = "CANCELED";
    case PAID = "PAID";
    case FREE = "FREE";

    public static function colors(): array
    {
        return [
            self::ACCEPTED->value => 'warning',
            self::CANCELED->value => 'danger',
            self::PAID->value => 'success',
            self::FREE->value => 'info',
        ];
    }
}
