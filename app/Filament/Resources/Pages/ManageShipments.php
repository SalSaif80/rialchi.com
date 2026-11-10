<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\ShipmentResource;
use App\Models\Customer;
use App\Models\Shipment;
use App\Support\Phone;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class ManageShipments extends ManageRecords
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('إضافة شحنة')->using(function (array $data) {
            $phone = Phone::normalize($data['phone'], $data['country']);
            if (! $phone) {
                throw ValidationException::withMessages([
                    'mountedActions.0.data.phone' => 'تحقق من رقم الجوال ومفتاح الدولة.',
                ]);
            }

            $customer = Customer::firstOrCreate(['phone' => $phone]);
            $shipment = Shipment::create(Arr::except($data, ['country', 'phone', 'shipment_status_id']) + ['customer_id' => $customer->id]);
            $shipment->events()->create(['shipment_status_id' => $data['shipment_status_id']]);

            return $shipment;
        })];
    }
}
