<?php

use App\Enum\OrderCountry;

return [
    'base_billing_country' => OrderCountry::SK,

    'vat_percentages' => [
        'SK' => 0, //23, // Slovakia
        'CZ' => 0, //21, // Czech Republic
        'HU' => 0, //27, // Hungary
        'AT' => 0, //20, // Austria
        'BE' => 0, //21, // Belgium
        'EE' => 0, //20, // Estonia
        'FI' => 0, //24, // Finland
        'FR' => 0, //20, // France
        'DE' => 0, //19, // Germany
        'GR' => 0, //24, // Greece
        'IT' => 0, //22, // Italy
        'LV' => 0, //21, // Latvia
        'LT' => 0, //21, // Lithuania
        'LU' => 0, //17, // Luxembourg
        'NL' => 0, //21, // Netherlands
        'PT' => 0, //23, // Portugal
        'SI' => 0, //22, // Slovenia
        'ES' => 0, //21, // Spain
    ],
];
