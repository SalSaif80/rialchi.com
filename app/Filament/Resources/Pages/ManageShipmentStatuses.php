<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\ShipmentStatusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageShipmentStatuses extends ManageRecords
{
    protected static string $resource = ShipmentStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label(__('إضافة حالة'))];
    }
}
