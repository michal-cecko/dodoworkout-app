<?php

namespace App\Filament\Resources;

use Filament\Resources\Concerns\Translatable;
use Synapps\Filament\Resources\CommonResource as SynappsResource;

abstract class CommonResource extends SynappsResource
{
    use Translatable;
}
