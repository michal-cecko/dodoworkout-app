<?php

namespace App\Filament\Trait;

use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;

trait UseMapField
{
    public static function getGoogleMapField(string $key = 'location', ?string $extractAddressToFieldKey = 'address'): array
    {
        $map = Map::make($key)
            ->columnSpan([
                'default' => 12,
            ])
            ->defaultLocation(latitude: 49.2428777, longitude: 18.7950987)
            ->liveLocation(true, true)
            ->afterStateUpdated(function (callable $set, ?array $state): void {
                $set('latitude', $state['lat']);
                $set('longitude', $state['lng']);
            })
            ->afterStateHydrated(function ($state, $record, callable $set): void {
                $set('location', [
                    'lat' => $record?->latitude,
                    'lng' => $record?->longitude,
                ]);
            })
            ->visible(fn ($get) => $get('has_location') === true)
            ->showFullscreenControl()
            ->showZoomControl()
            ->draggable()
            ->zoom(8)
            ->showMyLocationButton()
            ->clickable(true)
            ->showMarker();

        return [
            'has_location' => Checkbox::make('has_location')->label("Pridať lokalitu na mape?")->columnSpan([
                'default' => 12,
            ])->live(),
            'map' => $map,
            'latitude' => TextInput::make('latitude')->readOnly()->label("Zemepisná šírka")->columnSpan([
                'default' => 12,
            ]),
            'longitude' => TextInput::make('longitude')->readOnly()->label("Zemepisná šírka")->columnSpan([
                'default' => 12,
            ])
        ];
    }
}
