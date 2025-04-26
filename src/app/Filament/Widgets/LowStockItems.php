<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use App\Models\Item;

class LowStockItems extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected const LOW_STOCK_THRESHOLD = 5;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Item::query()
                    ->where('quantity', '<', self::LOW_STOCK_THRESHOLD)
                    ->orderBy('quantity', 'asc') 
                    ->with(['category', 'supplier'])
            )
            ->heading('Low Stock Items (< ' . self::LOW_STOCK_THRESHOLD . ' Units)')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('danger'),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('supplier.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->paginated(false);
            // ->defaultSort('quantity', 'asc');
            // ->description('Items that need restocking soon.');
    }
}
