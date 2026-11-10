<?php

use App\Http\Controllers\Rialchi\HomeController;
use App\Http\Controllers\Rialchi\TrackingController;
use App\Models\Shipment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', HomeController::class)->name('rialchi.home');
Route::get('/tracking', TrackingController::class)->name('rialchi.tracking');

Route::get('/tracking/{number}/photos/{index}', function (string $number, int $index) {
    $shipment = Shipment::where('number', $number)->firstOrFail();
    $path = $shipment->photos[$index] ?? null;
    abort_unless(is_string($path) && str_starts_with($path, 'shipment-photos/'), 404);

    return Storage::disk('local')->response($path);
})->whereNumber('index')->name('rialchi.shipment-photo');
