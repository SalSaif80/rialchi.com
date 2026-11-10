<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 16)->nullable()->unique();
            $table->string('role', 20)->nullable();
            $table->boolean('is_owner')->default(false);
        });
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 16)->unique();
            $table->timestamps();
        });
        Schema::create('shipment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->unique();
            $table->string('name')->unique();
            $table->timestamps();
        });
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('number', 32)->unique();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->string('destination')->nullable();
            $table->string('method')->nullable();
            $table->string('weight')->nullable();
            $table->text('details')->nullable();
            $table->json('photos')->nullable();
            $table->timestamps();
        });
        Schema::create('shipment_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shipment_status_id')->constrained()->restrictOnDelete();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_events');
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('shipment_statuses');
        Schema::dropIfExists('customers');
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone']);
            $table->dropColumn(['phone', 'role', 'is_owner']);
        });
    }
};
