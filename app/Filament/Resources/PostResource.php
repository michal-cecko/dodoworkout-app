<?php

namespace App\Filament\Resources;

use App\Enum\Locale;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Trait\UseContentBuilder;
use App\Models\Post;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;

class PostResource extends CommonResource
{
    use UseContentBuilder;

    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-s-newspaper';
    protected static ?string $modelLabel = "Článok";
    protected static ?string $pluralModelLabel = "Články";
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
                Placeholder::make('likes')
                    ->label("Hodnotenia článku")
                    ->content(fn($record) => "dobré: {$record?->likes}, zlé: {$record?->dislikes}")
                    ->visible(fn($get, $record) => $record && !$get('is_draft'))
                    ->columnSpan([
                        'default' => 6,
                        'sm' => 3,
                        'md' => 3,
                        'lg' => 4,
                    ])
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
            ->image()
            ->required()
            ->imageEditor()
            ->collection('image')
            ->columnSpan(12);

        $fields['tags'] = Select::make('tags')
            ->label("Značky")
            ->relationship("tags", "name")
            ->multiple()
            ->preload()
            ->searchable()
            ->createOptionForm(PostTagResource::getFormFields())
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

        $locales = collect(Locale::cases())->mapWithKeys(fn($locale) => [$locale->value => $locale->value])->toArray();
        $fields['locale_scope'] = Select::make('locale_scope')
            ->label("Článok dostupný v jazykoch")
            ->placeholder("Všetky jazyky")
            ->options($locales)
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 2,
                'lg' => 3,
            ]);

        $fields['published_at'] = DateTimePicker::make('published_at')
            ->label("Zverejnené dňa")
            ->native(false)
            ->weekStartsOnMonday()
            ->default(now())
            ->required()
            ->visible(fn($get) => !$get('is_draft'))
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 3,
                'lg' => 4,
            ]);

        $fields['content'] = self::getContentBuilder(fieldLabel: "Obsah článku");

        return $fields;
    }

    public static function getTableColumns(): array
    {
        $columns = [];

        $columns['image'] = SpatieMediaLibraryImageColumn::make('image')->label('Obrázok')->collection('image');
        $columns['title'] = TextColumn::make('title')->label('Titulok')->sortable()->searchable();
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
        $columns['published_at'] = TextColumn::make('published_at')->label('Publikované dňa')->dateTime()->sortable()->searchable();

        return $columns;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
