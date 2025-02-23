<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentTypeResource\Pages;
use App\Models\PaymentType;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;

class PaymentTypeResource extends CommonResource
{
    protected static ?string $model = PaymentType::class;
    protected static ?string $modelLabel = "Spôsob platby";
    protected static ?string $pluralModelLabel = "Spôsoby platby";
    protected static ?string $recordTitleAttribute = 'name';
    protected static string $defaultSortColumn = 'created_at';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        $fields = [];

        $fields['fields'] =
            Section::make([
                Grid::make([
                    'default' => 1,
                    'sm' => 3,
                    'md' => 6,
                    'lg' => 12,
                ])->schema(self::getFormFields())
            ]);

        $fields['timestamps'] = Section::make([
            Grid::make([
                'default' => 12,
                'sm' => 3,
                'md' => 6,
                'lg' => 12,
            ])->schema([
                self::getCreatedAtField()->columnSpan([
                    'default' => 6,
                    'sm' => 3,
                    'md' => 3,
                    'lg' => 4,
                ]),
                self::getUpdatedAtField()->columnSpan([
                    'default' => 6,
                    'sm' => 3,
                    'md' => 3,
                    'lg' => 4,
                ]),
            ])
        ])->hiddenOn("create");

        return $form->schema($fields);
    }

    public static function getFormFields(): array
    {
        $fields = [];

        $fields['name'] = TextInput::make('name')
            ->label("Názov")
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $fields['price'] = TextInput::make('price')
            ->label("Cena")
            ->numeric()
            ->suffix("€")
            ->minValue(0)
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $fields['desc'] = Textarea::make('description')
            ->label("Popis")
            ->rows(3)
            ->columnSpan([
                'default' => 12,
            ]);

        return $fields;
    }

    public static function getTableColumns(): array
    {
        $columns = [];

        $columns['name'] = TextColumn::make('name')->label('Názov')->sortable()->searchable();
        $columns['price'] = TextColumn::make('price')->label('Cena (€)')->numeric()->sortable()->searchable();

        return $columns;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentTypes::route('/'),
            'create' => Pages\CreatePaymentType::route('/create'),
            'edit' => Pages\EditPaymentType::route('/{record}/edit'),
        ];
    }
}
