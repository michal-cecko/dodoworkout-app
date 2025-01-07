<?php

namespace App\Filament\Resources\PostTagResource\RelationManagers;

use App\Filament\Resources\CommonResource\CommonRelationManager;
use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostTagResource;
use App\Models\PostTag;

class PostTagPostRelationManager extends CommonRelationManager
{
    protected static string $relationship = 'posts';
    protected static ?string $title = "Články s touto značkou";
    protected static array $eagerLoadTable = ['serviceType', 'serviceTypeCount'];

    public function tableColumns(): array
    {
        return PostResource::getTableColumns();
    }

    public static function ownerResource(): string
    {
        return PostTagResource::class;
    }

    public static function relatedResource(): string
    {
        return PostResource::class;
    }
}
