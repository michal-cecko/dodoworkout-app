<?php

namespace App\Filament\Contracts;

use Filament\Forms\Form;

interface ResourceFormFields
{
    public static function form(Form $form): Form;
}
