<?php

namespace App\Filament\Resources\CommonResource;

use App\Filament\Contracts\RelationManager;
use App\Filament\Trait\UseRelationManagerTable;
use Filament\Resources\RelationManagers\RelationManager as FilamentRelationManager;

abstract class CommonRelationManager extends FilamentRelationManager implements RelationManager
{
    use UseRelationManagerTable;
}
