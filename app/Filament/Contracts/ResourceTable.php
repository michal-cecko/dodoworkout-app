<?php

namespace App\Filament\Contracts;
use Filament\Tables\Table;

interface ResourceTable
{
    public static function table(Table $table): Table;
    public static function getTableColumns() : array;
    public static function getTableFilters() : array;
    public static function getTableActions() : array;
    public static function getTableBulkActions() : array;
}
