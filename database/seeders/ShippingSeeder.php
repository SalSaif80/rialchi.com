<?php

namespace Database\Seeders;

use App\Models\ShipmentStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShippingSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['تم استلام الشحنة', 'غادرت بلد المنشأ', 'في الطريق', 'وصلت بلد الوجهة', 'التخليص الجمركي', 'خرجت للتسليم', 'تم التسليم'] as $index => $name) {
            ShipmentStatus::firstOrCreate(['code' => 'initial-'.($index + 1)], ['name' => $name]);
        }

        foreach (['+966551998021', '+8618664022277'] as $phone) {
            if (User::where('phone', $phone)->exists()) {
                continue;
            }
            $owner = new User(['name' => 'مدير ريالتشي', 'role' => 'admin', 'phone' => $phone,
                'email' => Str::uuid().'@users.invalid', 'password' => Str::random(64)]);
            $owner->is_owner = true;
            $owner->save();
        }
    }
}
