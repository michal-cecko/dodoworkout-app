<?php

namespace App\Enum;

enum OrderStatus : string
{
    case ACCEPTED = "ACCEPTED";
    case CANCELED = "CANCELED";
    case PAID = "PAID";
    case FREE = "FREE";
}
