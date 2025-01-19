<?php

namespace App\Filament\Trait;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

trait UseContentBuilder
{
    public static function getContentBuilder($fieldLabel = "Obsah", $fieldKey = 'content') : Builder {
        return Builder::make($fieldKey)
            ->label($fieldLabel)
            ->blocks(self::getContentBuilderBlocks())
            ->addActionLabel('Pridať nový blok')
            ->reorderableWithButtons()
            ->collapsible()
            ->deleteAction(fn(Action $action) => $action->requiresConfirmation())
            ->columnSpan(12);
    }

    public static function getContentBuilderBlocks() : array {
        return [
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
        ];
    }
}
