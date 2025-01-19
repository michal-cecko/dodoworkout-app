<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommonResource\CommonResource;
use App\Filament\Resources\EventResource\Pages;
use App\Filament\Trait\UseContentBuilder;
use App\Filament\Trait\UseMapField;
use App\Models\Event;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;

class EventResource extends CommonResource
{
    use Translatable, UseContentBuilder, UseMapField;

    protected static ?string $model = Event::class;
    protected static ?string $navigationIcon = 'heroicon-c-calendar-days';
    protected static ?string $modelLabel = "Event";
    protected static ?string $pluralModelLabel = "Eventy";
    protected static ?string $recordTitleAttribute = 'title';
    protected static string $defaultSortColumn = 'created_at';

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

        $fields['title'] = TextInput::make('title')
            ->label("Titulok")
            ->required()
            ->columnSpan([
                'default' => 12,
            ]);

        $fields['excerpt'] = Textarea::make('excerpt')
            ->label("Popis")
            ->hint("Zobrazuje sa na kartách na domovskej stránke.")
            ->columnSpan([
                'default' => 12,
            ]);

        $fields['image'] = SpatieMediaLibraryFileUpload::make('image')
            ->label("Obrázok")
            ->preserveFilenames()
            ->required()
            ->image()
            ->imageEditor()
            ->collection('image')
            ->columnSpan(12);

        $fields['category_id'] = Select::make('category_id')
            ->label("Kategória")
            ->relationship("category", "name")
            ->preload()
            ->searchable()
            ->createOptionForm(EventCategoryResource::getFormFields())
            ->columnSpan(12);

        $fields['is_draft'] = Checkbox::make('is_draft')
            ->label("Uložiť ako koncept?")
            ->inline(false)
            ->live()
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['start_at'] = DateTimePicker::make('start_at')
            ->label("Začiatok eventu")
            ->native(false)
            ->weekStartsOnMonday()
            ->required()
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 3,
                'lg' => 4,
            ]);

        $fields['end_at'] = DateTimePicker::make('end_at')
            ->label("Koniec eventu")
            ->native(false)
            ->weekStartsOnMonday()
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 3,
                'lg' => 4,
            ]);

        $fields = array_merge($fields, self::getGoogleMapField());

        $fields['map']->label("Miesto konania");

        $fields['address'] = TextInput::make('address')
            ->label("Adresa miesta konania")
            ->columnSpan([
                'default' => 12,
            ]);

        $fields['participants_count'] = TextInput::make('participants_count')
            ->label("Max. počet účastníkov")
            ->numeric()
            ->minValue(1)
            ->columnSpan([
                'default' => 12,
            ]);

        $fields['price'] = TextInput::make('price')
            ->label("Cena")
            ->numeric()
            ->suffix("€")
            ->minValue(1)
            ->columnSpan([
                'default' => 12,
            ]);

        $fields['last_price'] = TextInput::make('last_price')
            ->label("Cena pred zľavou")
            ->numeric()
            ->suffix("€")
            ->minValue(1)
            ->columnSpan([
                'default' => 12,
            ]);

        $fields['content'] = self::getContentBuilder(fieldLabel: "Obsah článku");

        return $fields;
    }

    public static function getTableColumns(): array
    {
        $columns = [];

        $columns['image'] = SpatieMediaLibraryImageColumn::make('image')->label('Obrázok')->collection('image');
        $columns['title'] = TextColumn::make('title')->label('Titulok')->sortable()->searchable();
        $columns['category_id'] = TextColumn::make('category.name')->label('Kategória')->sortable()->searchable();
        $columns['price'] = TextColumn::make('price')->label('Cena (€)')->numeric()->sortable()->searchable();
        $columns['is_published'] = IconColumn::make('is_published')
            ->label('Je publikovaný?')
            ->sortable(['is_draft'])
            ->icon(fn(bool $state): string => match ($state) {
                true => 'heroicon-s-check-circle',
                false => 'heroicon-s-x-circle',
            })->color(fn(bool $state): string => match ($state) {
                true => "success",
                false => "danger",
            });

        return $columns;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
