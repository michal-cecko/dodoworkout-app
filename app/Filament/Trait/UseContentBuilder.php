<?php

namespace App\Filament\Trait;

use App\Models\Event;
use App\Models\Post;
use Exception;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait UseContentBuilder
{
    public static function getContentBuilder($fieldLabel = "Obsah", $fieldKey = 'content'): Builder
    {
        return Builder::make($fieldKey)
            ->label($fieldLabel)
            ->blocks(self::getContentBuilderBlocks())
            ->addActionLabel('Pridať nový blok')
            ->reorderableWithButtons()
            ->collapsible()
            ->deleteAction(fn(Action $action) => $action->requiresConfirmation())
            ->columnSpan(12);
    }

    public static function getContentBuilderBlocks(): array
    {
        return [
            Block::make('content')
                ->label("Text")
                ->schema([
                    TiptapEditor::make('content')
                        ->required(),
                ]),
            Block::make('media')
                ->label("Obrázok / Video")
                ->schema([
                    FileUpload::make('media')
                        ->label('Médium')
                        ->disk("public")
                        ->directory(fn ($record) => self::getMediaDirectory($record))
                        ->required()
                        ->preserveFilenames()
                        ->imageEditor(),
                    Checkbox::make('is_video')
                        ->label('Video?')
                        ->inline(false),
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
                    FileUpload::make('images')
                        ->label('Obrázky')
                        ->disk("public")
                        ->preserveFilenames()
                        ->directory(fn ($record) => self::getMediaDirectory($record))
                        ->multiple()
                        ->panelLayout("grid")
                        ->required()
                        ->imageEditor()
                ]),
        ];
    }

    public static function getMediaDirectory($record): string
    {
        if(!$record) {
            if(!Storage::disk('public')->exists('temp-builder')) {
                Storage::disk('public')->makeDirectory('temp-builder');
            }

            return "temp-builder";
        }

        return $record->builder_images_path;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;

        $tempDirectory = 'temp-builder';
        $finalDirectory = $record->builder_images_path;

        if (Storage::disk('public')->exists($tempDirectory)) {
            // Move files from the temporary directory to the final directory
            $files = Storage::disk('public')->files($tempDirectory);

            // Decode the JSON content column
            $content = $record->content;

            foreach ($files as $file) {
                // Generate the new path
                $newPath = str_replace($tempDirectory, $finalDirectory, $file);

                // Move the file
                Storage::disk('public')->move($file, $newPath);

                // Update the paths in the JSON content
                $this->updateFilePathsInContent($content, $file, $newPath);
            }

            // Save the updated content back to the record
            $record->content = $content;
            $record->save();

            Storage::disk('public')->delete($tempDirectory . '/*');
        }
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        $directory = $record->builder_images_path;

        if (Storage::disk('public')->exists($directory)) {
            $files = Storage::disk('public')->files($directory);
            $content = $record->content;

            foreach ($content as $block => $data) {
                if($data['type'] !== 'gallery') {
                    continue;
                }

                foreach ($files as $file) {
                    if (!in_array($file, $data['data']['images'])) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
        }
    }

    /**
     * Update file paths in the JSON content.
     *
     * @param array $content
     * @param string $oldPath
     * @param string $newPath
     */
    protected function updateFilePathsInContent(array &$content, string $oldPath, string $newPath): void
    {
        foreach ($content as $block => $data) {
            if (!in_array($data['type'], ['gallery', 'media'])) {
                continue;
            }

            if($data['type'] === 'media' && $data['data']['media'] === $oldPath) {
                $content[$block]['data']['media'] = $newPath;
            } else if ($data['type'] === "gallery") {
                $updatedImages = array_map(function ($image) use ($oldPath, $newPath) {
                    return $image === $oldPath ? $newPath : $image;
                }, $data['data']['images']);

                $content[$block]['data']['images'] = $updatedImages;
            }
        }
    }
}
