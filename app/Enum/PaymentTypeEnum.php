<?php

namespace App\Enum;

enum PaymentTypeEnum : string
{
    case COD = "COD";
    case BANK_TRANSFER = "BANK_TRANSFER";
    case CARD = "CARD";
}
