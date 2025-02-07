<?php

use App\Providers\Filament\DashboardPanelProvider;
use Synapps\Filament\Providers\FilamentProvider;
use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    DashboardPanelProvider::class,
    FilamentProvider::class,
];
