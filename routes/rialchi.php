<?php

use App\Http\Controllers\Rialchi\HomeController;
use App\Http\Controllers\Rialchi\TrackingController;
use App\Models\Shipment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', HomeController::class)->name('rialchi.home');
Route::get('/tracking', TrackingController::class)->name('rialchi.tracking')->middleware('throttle:30,1');
Route::get('/admin/shipment-photos/{number}/{index}', function (string $number, int $index) {
    abort_unless(auth()->user()?->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')), 403);
    $shipment = Shipment::where('number', $number)->firstOrFail();
    $path = $shipment->photos[$index] ?? null;
    abort_unless(is_string($path) && str_starts_with($path, 'shipment-photos/'), 404);

    return Storage::disk('local')->response($path, null, ['Cache-Control' => 'private, no-store']);
})->whereNumber('index')->name('rialchi.shipment-photo');
