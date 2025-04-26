<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierSummary extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
             ->query(
                Supplier::query()
                    ->select([
                        'suppliers.id',
                        'suppliers.name',
                        DB::raw('COUNT(items.id) as items_count'),
                        DB::raw('SUM(items.price * items.quantity) as total_value'),
                        DB::raw('SUM(items.quantity) as total_units'),
                    ])
                    ->leftJoin('items', 'suppliers.id', '=', 'items.supplier_id')
                    ->groupBy('suppliers.id', 'suppliers.name')
                    ->orderBy('suppliers.name')
            )
            ->heading('Supplier Summary')
            ->columns([
                TextColumn::make('name')
                    ->label('Supplier Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('items_count')
                    ->label('Item Types Supplied')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_units')
                    ->label('Total Units Supplied')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_value')
                    ->label('Total Value Supplied')
                    ->money('IDR')
                    ->sortable(),
            ])
             ->paginated(false);
    }
}
