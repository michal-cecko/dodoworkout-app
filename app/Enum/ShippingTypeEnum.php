<?php

namespace App\Enum;

enum ShippingTypeEnum : string
{
    case EMAIL = "EMAIL";
    case COURIER = "COURIER";
    case PERSON = "PERSON";
}
