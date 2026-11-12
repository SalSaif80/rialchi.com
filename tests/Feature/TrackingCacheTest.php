<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class TrackingCacheTest extends TestCase
{
    use RefreshDatabase;

    public function test_tracking_ignores_legacy_cached_models_and_shows_live_updates(): void
    {
        app()->setLocale('ar');
        config(['cache.default' => 'database', 'cache.serializable_classes' => false]);
        $customer = Customer::create(['phone' => '+966551234567']);
        $shipment = Shipment::create(['customer_id' => $customer->id]);
        $received = ShipmentStatus::create(['name' => 'استلام تجريبي']);
        $shipment->events()->create(['shipment_status_id' => $received->id]);
        $key = 'shipment:tracking:'.hash('sha256', $shipment->number);
        Cache::put($key, $shipment->load('events.status'), 600);
        $this->assertInstanceOf(\__PHP_Incomplete_Class::class, Cache::get($key));

        $this->get($shipment->trackingUrl())->assertOk()->assertSee($received->name);
        $arrived = ShipmentStatus::create(['name' => 'وصول تجريبي']);
        $shipment->events()->create(['shipment_status_id' => $arrived->id, 'location' => 'موقع محدث']);
        $this->get($shipment->trackingUrl())->assertOk()->assertSee($arrived->name)->assertSee('موقع محدث');

        $shipment->events()->delete();
        $shipment->delete();
        $this->get($shipment->trackingUrl())->assertOk()->assertSee('لم نجد شحنة');
        $this->get('/tracking')->assertOk();
    }
}
