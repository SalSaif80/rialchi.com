<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipment_statuses', function (Blueprint $table) {
            $table->string('name_en', 100)->nullable();
            $table->string('name_zh', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('shipment_statuses', fn (Blueprint $table) => $table->dropColumn(['name_en', 'name_zh']));
    }
};
