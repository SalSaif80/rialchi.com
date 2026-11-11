<?php

namespace App\Http\Controllers\Rialchi;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final class TrackingController extends Controller
{
    public function __invoke(Request $request): View
    {
        $validated = $request->validate([
            'number' => [
                'nullable',
                'string',
                'max:80',
                'regex:/^[A-Za-z0-9\-]+$/',
            ],
        ]);

        $number   = isset($validated['number']) ? strtoupper(trim($validated['number'])) : '';
        $searched = $request->has('number');
        $valid    = $number !== '' && mb_strlen($number) <= 80;

        $shipment = $valid ? $this->findShipment($number) : null;

        return view('rialchi.pages.tracking', compact('number', 'searched', 'valid', 'shipment'));
    }

    private function findShipment(string $number): ?Shipment
    {
        $cacheKey = 'shipment:tracking:' . hash('sha256', $number);

        return Cache::remember(
            key: $cacheKey,
            ttl: now()->addMinutes(10),
            callback: fn (): ?Shipment => Shipment::query()
                ->where('number', $number)
                ->with('events.status')
                ->first(),
        );
    }
}