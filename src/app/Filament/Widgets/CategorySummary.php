<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySummary extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Category::query()
                    ->select([
                        'categories.id',
                        'categories.name',
                        DB::raw('COUNT(items.id) as items_count'),
                        DB::raw('SUM(items.price * items.quantity) as total_value'),
                        DB::raw('AVG(items.price) as average_price')
                    ])
                    ->leftJoin('items', 'categories.id', '=', 'items.category_id')
                    ->groupBy('categories.id', 'categories.name')
                    ->orderBy('categories.name')
            )
            ->heading('Category Summary')
            ->columns([
                TextColumn::make('name')
                    ->label('Category Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('items_count')
                    ->label('Item Types')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_value')
                    ->label('Total Stock Value')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('average_price')
                    ->label('Avg. Item Price')
                    ->money('IDR')
                    ->sortable(),
            ])
             ->paginated(false);
    }
}
