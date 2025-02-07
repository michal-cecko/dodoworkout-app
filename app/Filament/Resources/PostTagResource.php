<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostTagResource\Pages;
use App\Models\PostTag;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Columns\TextColumn;

class PostTagResource extends CommonResource
{
    use Translatable;

    protected static ?string $model = PostTag::class;

    protected static ?string $navigationIcon = 'heroicon-c-tag';
    protected static ?string $modelLabel = "Značka článku";
    protected static ?string $pluralModelLabel = "Značky článkov";
    protected static ?string $recordTitleAttribute = 'name';
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

        $fields['name'] = TextInput::make('name')->label("Názov")->required()->columnSpan([
            'default' => 12,
            'sm' => 3,
            'md' => 4,
            'lg' => 7,
        ]);
        $fields['created_at'] = self::getCreatedAtField()->columnSpan([
            'default' => 6,
            'sm' => 3,
            'md' => 3,
            'lg' => 3,
        ]);
        $fields['updated_at'] = self::getUpdatedAtField()->columnSpan([
            'default' => 6,
            'sm' => 3,
            'md' => 3,
            'lg' => 2,
        ]);

        return $fields;
    }

    public static function getTableColumns(): array
    {
        $columns = [];

        $columns['name'] = TextColumn::make('name')->label('Názov')->sortable()->searchable();
        $columns['created_at'] = TextColumn::make('created_at')->label('Vytvorené dňa')->dateTime("j. M Y, H:i")->sortable()->searchable();

        return $columns;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostTags::route('/'),
            'create' => Pages\CreatePostTag::route('/create'),
            'edit' => Pages\EditPostTag::route('/{record}/edit'),
        ];
    }
}
