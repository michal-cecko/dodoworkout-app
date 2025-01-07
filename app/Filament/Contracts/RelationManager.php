<?php

namespace App\Filament\Contracts;
use Filament\Tables\Table;

interface RelationManager
{
    public static function ownerResource() : string;
    public static function relatedResource() : string;
}
