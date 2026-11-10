<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ShipmentResource;
use App\Models\Customer;
use App\Models\Shipment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ShippingOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي الشحنات', Shipment::count())->url(ShipmentResource::getUrl()),
            Stat::make('شحنات أضيفت اليوم', Shipment::where('created_at', '>=', now('Asia/Riyadh')->startOfDay()->utc())->count()),
            Stat::make('العملاء', Customer::count()),
        ];
    }
}
