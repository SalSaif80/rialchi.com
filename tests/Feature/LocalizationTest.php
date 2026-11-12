<?php

namespace Tests\Feature;

use App\Filament\Resources\Pages\ManageShipmentStatuses;
use App\Filament\Widgets\ShippingOverview;
use App\Models\Customer;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_and_login_support_all_three_languages(): void
    {
        foreach (['ar' => ['rtl', 'تبي تستورد؟', 'رقم الجوال'], 'en' => ['ltr', 'Looking to import?', 'Phone number'], 'zh_CN' => ['ltr', '想进口商品？', '手机号码']] as $locale => [$direction, $heading, $phone]) {
            $this->get('/?locale='.$locale)->assertOk()->assertSee('dir="'.$direction.'"', false)->assertSee($heading);
            $this->get('/tracking')->assertOk()->assertSee('dir="'.$direction.'"', false);
            $this->get('/admin/login')->assertOk()->assertSee($phone)->assertSee('name="locale"', false);
        }
        $this->get('/?locale[]=en')->assertOk()->assertSee('想进口商品？');
        $this->get('/?locale=unsupported')->assertOk()->assertSee('想进口商品？');
    }

    public function test_non_arabic_homepages_do_not_leave_untranslated_visible_text(): void
    {
        foreach (['en', 'zh_CN'] as $locale) {
            $html = $this->get('/?locale='.$locale)->assertOk()->getContent();
            $dom = new \DOMDocument;
            @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);
            $xpath = new \DOMXPath($dom);
            foreach ($xpath->query('//body//text()[not(ancestor::script) and not(ancestor::option) and not(ancestor::style) and not(ancestor::div[@class="language-options"])]') as $node) {
                $this->assertDoesNotMatchRegularExpression('/[\x{0600}-\x{06ff}]/u', $node->textContent);
            }
        }
    }

    public function test_translated_statuses_and_customer_data_are_shown_without_mutating_records(): void
    {
        $customer = Customer::create(['phone' => '+966551234567']);
        $shipment = Shipment::create(['customer_id' => $customer->id, 'method' => 'بحري', 'details' => 'Client text remains unchanged']);
        $status = ShipmentStatus::firstOrCreate(['name' => 'تم استلام الشحنة']);
        $shipment->events()->create(['shipment_status_id' => $status->id]);
        $this->get('/tracking?number='.$shipment->number.'&locale=en')->assertOk()->assertSee('Shipment received')->assertSee('Sea')->assertSee($shipment->details);
        $this->get('/tracking?number='.$shipment->number.'&locale=zh_CN')->assertOk()->assertSee('已收到货件')->assertSee('海运')->assertSee($shipment->details);
        $status->update(['name_en' => 'Received at our warehouse', 'name_zh' => '已入库']);
        $this->get('/tracking?number='.$shipment->number.'&locale=zh_CN')->assertOk()->assertSee('已入库');
        $this->assertSame('تم استلام الشحنة', $status->fresh()->name);
    }

    public function test_admin_navigation_and_modal_fields_use_the_selected_language(): void
    {
        $admin = User::factory()->create(['phone' => '+966551234567', 'role' => 'admin']);
        $this->actingAs($admin)->get('/admin?locale=zh_CN')->assertOk()->assertSee('Rialchi 管理后台');
        $this->get('/admin/shipments')->assertOk()->assertSee('添加货件');
        $this->get('/admin/users')->assertOk()->assertSee('添加用户');
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        Livewire::test(ShippingOverview::class)->assertSee('货件总数');
        Livewire::test(ManageShipmentStatuses::class)->callAction('create', [
            'name' => 'حالة مخصصة', 'name_en' => 'Custom status', 'name_zh' => '自定义状态',
        ])->assertHasNoFormErrors();
        $this->assertDatabaseHas('shipment_statuses', ['name_zh' => '自定义状态']);
    }

    public function test_translation_catalogs_have_identical_keys_and_preserve_placeholders(): void
    {
        $arabic = json_decode(file_get_contents(lang_path('ar.json')), true);
        foreach (['en', 'zh_CN'] as $locale) {
            $translations = json_decode(file_get_contents(lang_path($locale.'.json')), true);
            $this->assertEqualsCanonicalizing(array_keys($arabic), array_keys($translations));
            foreach ($arabic as $key => $value) {
                preg_match_all('/:[a-z_]+/', $value, $expected);
                preg_match_all('/:[a-z_]+/', $translations[$key], $actual);
                $this->assertEqualsCanonicalizing($expected[0], $actual[0], $key);
                $this->assertNotSame('', $translations[$key]);
            }
        }
    }
}
