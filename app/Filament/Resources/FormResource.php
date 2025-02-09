<?php

namespace App\Filament\Resources;

use App\Enum\FormFieldFormat;
use App\Filament\Resources\FormResource\Pages;
use App\Filament\Resources\FormResource\RelationManagers;
use App\Models\Form as FormModel;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class FormResource extends CommonResource
{
    protected static ?string $model = FormModel::class;
    protected static ?string $modelLabel = "Formulár";
    protected static ?string $pluralModelLabel = "Formuláre";
    protected static ?string $recordTitleAttribute = 'name';
    protected static string $defaultSortColumn = 'created_at';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->label("Názov formuláru")
            ->required()
            ->columnSpan([
                'default' => 12,
            ]);

        $fields['fields'] = self::getFieldsRepeater();

        return $fields;
    }

    public static function getTableColumns(): array
    {
        $columns = [];

        $columns['name'] = TextColumn::make('name')->label('Názov')->sortable()->searchable();

        return $columns;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }

    private static function getFieldsRepeater(): Repeater
    {
        $fields = [];

        $fields['label'] = TextInput::make('label')->label("Názov poľa")
            ->required()->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['format'] = Select::make('format')
            ->label("Formát")
            ->live()
            ->placeholder("Vyberte formát poľa")
            ->default(FormFieldFormat::TEXT->value)
            ->options(FormFieldFormat::translations())
            ->required()
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['help_text'] = TextInput::make('help_text')->label("Popis")->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['is_required'] = Checkbox::make('is_required')->label("Je povinné?")
            ->inline(false)
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['min_select'] = TextInput::make('min_select')
            ->label("Minimálny počet výberov")
            ->numeric()
            ->afterStateHydrated(fn(?Model $record, callable $set) => $set('min_select', !empty($record->min) ? (int) $record->min : null))
            ->visible(fn($get) => in_array($get('format'), [FormFieldFormat::SELECT->value, FormFieldFormat::CHECKBOX->value]))
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['max_select'] = TextInput::make('max_select')
            ->label("Maximálny počet výberov")
            ->numeric()
            ->afterStateHydrated(fn(?Model $record, callable $set) => $set('max_select', !empty($record->max) ? (int) $record->max : null))
            ->visible(fn($get) => in_array($get('format'), [FormFieldFormat::SELECT->value, FormFieldFormat::CHECKBOX->value]))
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['min_number'] = TextInput::make('min_number')
            ->label("Minimálna hodnota (vrátane)")
            ->numeric()
            ->afterStateHydrated(fn(?Model $record, callable $set) => $set('min_number', !empty($record->min) ? (int) $record->min : null))
            ->visible(fn($get) => in_array($get('format'), [FormFieldFormat::NUMBER->value]))
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['max_number'] = TextInput::make('max_number')
            ->label("Maximálna hodnota (vrátane)")
            ->numeric()
            ->afterStateHydrated(fn(?Model $record, callable $set) => $set('max_number', !empty($record->max) ? (int) $record->max : null))
            ->visible(fn($get) => in_array($get('format'), [FormFieldFormat::NUMBER->value]))
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['min_date'] = DateTimePicker::make('min_date')
            ->label("Minimálna hodnota (vrátane)")
            ->native(false)
            ->default(now())
            ->visible(fn($get) => in_array($get('format'), [
                FormFieldFormat::DATE->value,
                FormFieldFormat::DATETIME->value,
            ]))
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['max_date'] = DateTimePicker::make('max_date')
            ->label("Maximálna hodnota (vrátane)")
            ->native(false)
            ->default(now())
            ->visible(fn($get) => in_array($get('format'), [
                FormFieldFormat::DATE->value,
                FormFieldFormat::DATETIME->value,
            ]))
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['min_time'] = TimePicker::make('min_time')
            ->label("Minimálna hodnota (vrátane)")
            ->native(false)
            ->visible(fn($get) => in_array($get('format'), [
                FormFieldFormat::TIME->value,
            ]))
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['max_time'] = TimePicker::make('max_time')
            ->label("Maximálna hodnota (vrátane)")
            ->native(false)
            ->visible(fn($get) => in_array($get('format'), [
                FormFieldFormat::TIME->value,
            ]))
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['options'] = Repeater::make('options')->label("Možnosti")
            ->columnSpan('full')
            ->addActionLabel('Pridať možnosť')
            ->grid(4)
            ->cloneable()
            ->reorderable()
            ->reorderableWithButtons()
            ->collapsible()
            ->visible(fn($get) => in_array($get('format'), [FormFieldFormat::SELECT->value, FormFieldFormat::CHECKBOX->value]))
            ->deleteAction(fn(Action $action) => $action->requiresConfirmation())
            ->itemLabel(fn (array $state): ?string => $state['value'] ?? null)
            ->schema([
                TextInput::make('value')->label("Hodnota")->required()->columnSpan("full")
            ]);

        return Repeater::make('fields')
            ->label("Polia formuláru")
            ->relationship()
            ->columnSpan('full')
            ->addActionLabel('Pridať nové pole')
            ->cloneable()
            ->reorderable()
            ->reorderableWithButtons()
            ->collapsible()
            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
            ->deleteAction(fn(Action $action) => $action->requiresConfirmation())
            ->schema([Grid::make([
                'default' => 12,
                'sm' => 3,
                'md' => 6,
                'lg' => 12,
            ])->schema($fields)]);
    }
}
