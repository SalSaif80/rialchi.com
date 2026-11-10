<?php

use Database\Seeders\ShippingSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        (new ShippingSeeder)->run();
    }

    public function down(): void
    {
        // Keep user accounts and editable shipment statuses on rollback.
    }
};
