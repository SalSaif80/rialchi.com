<?php

namespace Tests\Feature;

use App\Filament\Pages\PhoneLogin;
use App\Filament\Resources\Pages\ManageShipments;
use App\Filament\Resources\Pages\ManageUsers;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use App\Models\User;
use Database\Seeders\ShippingSeeder;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShippingPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_creates_staff_and_staff_records_a_trackable_shipment(): void
    {
        $this->seed(ShippingSeeder::class);
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $owner = User::where('phone', '+966551998021')->firstOrFail();
        $owner->update(['password' => 'Testing-Only-2026']);
        Livewire::test(PhoneLogin::class)->fillForm(['phone' => '0551998021', 'password' => 'Testing-Only-2026'])
            ->call('authenticate')->assertHasNoErrors();
        $this->assertAuthenticatedAs($owner);
        Livewire::test(ManageUsers::class)->callAction('create', [
            'name' => 'موظف', 'phone' => '+966551234567', 'password' => 'Another-Test-Password', 'role' => 'staff',
        ])->assertHasNoFormErrors();
        auth()->logout();
        session()->invalidate();
        $this->actingAs(User::where('phone', '+966551234567')->firstOrFail());
        $this->get('/admin/users')->assertForbidden();
        $this->get('/admin/shipment-statuses')->assertForbidden();
        $status = ShipmentStatus::firstOrFail();
        Livewire::test(ManageShipments::class)->callAction('create', [
            'country' => 'SA', 'phone' => '0551998021', 'shipment_status_id' => $status->id, 'destination' => 'القصيم',
        ])->assertHasNoFormErrors();
        $shipment = Shipment::sole();
        $this->assertMatchesRegularExpression('/^RLC-[0-9A-F]{16}$/', $shipment->number);
        Livewire::test(ManageShipments::class)->callAction(TestAction::make('updateStatus')->table($shipment), [
            'shipment_status_id' => ShipmentStatus::max('id'), 'location' => 'بريدة',
        ])->assertHasNoFormErrors();
        $this->assertCount(2, $shipment->events);
        $photo = 'shipment-photos/test.jpg';
        \Illuminate\Support\Facades\Storage::fake('local')->put($photo, 'test image');
        $shipment->update(['photos' => [$photo], 'details' => 'وصف خاص بالشحنة']);
        $photoUrl = route('rialchi.shipment-photo', [$shipment->number, 0]);
        $this->get($photoUrl)->assertOk();
        $this->assertFalse($owner->can('delete', $status));
        $unused = ShipmentStatus::create(['name' => 'حالة غير مستخدمة']);
        $this->assertTrue($owner->can('delete', $unused));

        auth()->logout();
        $this->get($photoUrl)->assertForbidden();
        $this->get('/tracking/'.$shipment->number.'/photos/0')->assertNotFound();
        $this->get($shipment->trackingUrl())->assertDontSee($photoUrl)->assertSee('وصف خاص بالشحنة')
            ->assertSeeInOrder(['تم تسجيل الشحنة وإصدار رقم التتبع', $status->name, 'بريدة']);
        $this->get($shipment->trackingUrl())->assertOk()->assertSee('بريدة')->assertSee('القصيم')->assertDontSee('+966551998021');
        $this->get('/tracking?number=unknown')->assertOk()->assertSee('لم نجد شحنة');
    }
}
