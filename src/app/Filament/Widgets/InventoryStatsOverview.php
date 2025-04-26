<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Supplier;
use App\Models\Item;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class InventoryStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalStockValue = Item::sum(DB::raw('price * quantity'));
        $totalItemCount = Item::sum('quantity');
        $distinctItemCount = Item::count();
        $averageItemPrice = Item::avg('price');

        return [
            Stat::make('Total Items (Units)', Number::format($totalItemCount ?? 0))
                ->description('Total quantity of all items in stock')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
            Stat::make('Total Stock Value', Number::currency($totalStockValue ?? 0, 'IDR'))
                ->description('Total value of all items (price*qty)')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            Stat::make('Average Item Price', Number::currency($averageItemPrice ?? 0, 'IDR'))
                ->description('Average price per item type')
                ->descriptionIcon('heroicon-m-receipt-percent')
                ->color('info'),
            Stat::make('Total Categories', Category::count())
                 ->description('Number of item categories')
                 ->descriptionIcon('heroicon-m-tag')
                ->color('warning'),
            Stat::make('Total Suppliers', Supplier::count())
                ->description('Number of registered suppliers')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),
            Stat::make('Distinct Item Types', $distinctItemCount)
                 ->description('Number of different item types listed')
                 ->descriptionIcon('heroicon-m-archive-box')
                ->color('primary'),

        ];
    }
}
