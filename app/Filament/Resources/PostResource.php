<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommonResource\CommonResource;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\PostTag;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
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

class PostResource extends CommonResource
{
    use Translatable;

    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-s-newspaper';
    protected static ?string $modelLabel = "Článok";
    protected static ?string $pluralModelLabel = "Články";
    protected static ?string $recordTitleAttribute = 'title';


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
                    ->content(fn($record) => "dobré: {$record?->likes} | zlé: {$record?->dislikes}")
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
            ->imageEditor()
            ->collection('image')
            ->columnSpan(12);

        $fields['tags'] = Select::make('tags')
            ->label("Značky")
            ->relationship('tags', 'default_name', fn ($query) => $query->select('post_tags.id', 'default_name'))
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

        $fields['published_at'] = DateTimePicker::make('published_at')
            ->label("Zverejnené dňa")
            ->native(false)
            ->firstDayOfWeek(1)
            ->default(now())
            ->visible(fn($get) => !$get('is_draft'))
            ->columnSpan([
                'default' => 6,
                'sm' => 3,
                'md' => 3,
                'lg' => 4,
            ]);

        $fields['content'] = Builder::make('content')
            ->label("Obsah článku")
            ->blocks([
                Block::make('content')
                    ->label("Text")
                    ->schema([
                        RichEditor::make('content')
                            ->label("Text")
                            ->toolbarButtons(['bold', 'bulletList', 'h1', 'h2', 'h3', 'italic', 'link', 'orderedList', 'redo', 'strike', 'underline', 'undo',])
                    ]),
                Block::make('image')
                    ->label("Obrázok / Video")
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->label('Médium')
                            ->required()
                            ->imageEditor()
                            ->collection('content_media'),
                        RichEditor::make('description')
                            ->label("Popis média")
                            ->toolbarButtons(['bold', 'italic', 'link', 'redo', 'strike', 'underline', 'undo'])
                    ]),
                Block::make('blockquote')
                    ->label("Citát")
                    ->schema([
                        Grid::make([
                            'default' => 2,
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 2,
                        ])->schema([
                            Textarea::make('text')->label('Obsah citátu')->required()->columnSpan(2),
                            TextInput::make('author')->label('Autor')->columnSpan(1),
                            TextInput::make('position')->label('Pozícia / Popis autora')->columnSpan(1),
                        ]),
                    ]),
                Block::make('gallery')
                    ->label("Galéria")
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('images')
                            ->label('Obrázky')
                            ->multiple()
                            ->required()
                            ->imageEditor()
                            ->collection('content_media'),
                    ]),
            ])
            ->addActionLabel('Pridať nový blok')
            ->reorderableWithButtons()
            ->collapsible()
            ->deleteAction(fn(Action $action) => $action->requiresConfirmation())
            ->columnSpan(12);

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
            ->icon(fn (bool $state): string => match ($state) {
                true => 'heroicon-s-check-circle',
                false => 'heroicon-s-x-circle',
            })->color(fn (bool $state): string => match ($state) {
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
