<?php

namespace App\Filament\Trait;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

trait UseResourceTable
{
    protected static array $eagerLoadTable = [];
    protected static string $defaultSortColumn = 'id';
    protected static string $defaultSortDirection = 'desc';

    public static function table(Table $table): Table
    {
        $table = $table
            ->columns(static::getTableColumns())
            ->filters(static::getTableFilters())
            ->actions(static::getTableActions(), position: static::getTableActionsPosition())
            ->bulkActions(static::getTableBulkActions())
            ->persistFiltersInSession()
            ->extremePaginationLinks()
            ->paginated([25, 50, 100, 'all'])
            ->striped()
            ->recordAction('edit')
            ->defaultPaginationPageOption(25)
            ->defaultSort(static::$defaultSortColumn, static::$defaultSortDirection);

        if (!empty(static::$eagerLoadTable)) {
            $table->modifyQueryUsing(function ($query) {
                $query->with(static::$eagerLoadTable);
            });
        }

        return $table;
    }

    public static function getTableColumns(): array
    {
        return [];
    }

    public static function getTableFilters(): array
    {
        return [
            'id' => Filter::make('id')
                ->form([
                    Grid::make([
                        'default' => 12,
                    ])->schema([
                        TextInput::make('id_from')->label("ID od")->numeric()->minValue(1)->columnSpan(6),
                        TextInput::make('id_until')->label("ID do")->numeric()->minValue(1)->columnSpan(6),
                    ])
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['id_from'],
                            fn(Builder $query, $date): Builder => $query->where('id', '>=', $date),
                        )
                        ->when(
                            $data['id_until'],
                            fn(Builder $query, $date): Builder => $query->where('id', '<=', $date),
                        );
                }),
            'created_at' => Filter::make('created_at')
                ->form([
                    DateTimePicker::make('created_from')->label("Vytvorené od")->native(false),
                    DateTimePicker::make('created_until')->label("Vytvorené do")->native(false),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
        ];
    }

    public static function getTableActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public static function getTableActionsPosition(): ActionsPosition
    {
        return ActionsPosition::AfterColumns;
    }

    public static function getTableBulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
            ])
        ];
    }
}
