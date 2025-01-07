<?php

namespace App\Filament\Trait;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait UseRelationManagerTable
{
    protected static array $eagerLoadTable = [];
    protected static string $defaultSortColumn = 'id';
    protected static string $defaultSortDirection = 'desc';

    public function table(Table $table): Table
    {
        $table = $table
            ->recordTitleAttribute($this->getRecordTitleAttribute())
            ->columns($this->tableColumns())
            ->filters($this->getTableFilters())
            ->actions($this->getTableActions())
            ->headerActions($this->getTableHeaderActions())
            ->bulkActions($this->getTableBulkActions())
            ->paginated([25, 50, 100, 'all'])
            ->striped()
            ->defaultPaginationPageOption(25)
            ->defaultSort(static::$defaultSortColumn, static::$defaultSortDirection)
            ->persistFiltersInSession();

        if (!empty(static::$eagerLoadTable)) {
            $table->modifyQueryUsing(function ($query) {
                $query->with(static::$eagerLoadTable);
            });
        }

        return $table;
    }

    public static function getRecordTitleAttribute(): string
    {
        return 'name';
    }

    public function tableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->label('ID'),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            'id' => Filter::make('id')
                ->form([
                    Grid::make()->schema([
                        TextInput::make('id_from')->label("ID od")->numeric()->minValue(1),
                        TextInput::make('id_until')->label("ID do")->numeric()->minValue(1),
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

    public function getTableActions(): array
    {
        $viaParamName = "via" . class_basename(static::ownerResource()::getModel());

        return [
            EditAction::make()->url(fn(Model $record, $livewire): string => static::relatedResource()::getUrl('edit', ['record' => $record, $viaParamName => $livewire->ownerRecord->getKey()])),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public function getTableHeaderActions(): array
    {
        $viaParamName = "via" . class_basename(static::ownerResource()::getModel());

        return [
            CreateAction::make()->url(fn($livewire) => static::relatedResource()::getUrl('create', [
                $viaParamName => $livewire->ownerRecord->getKey()
            ])),
        ];
    }

    public function getTableBulkActions(): array
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
