<?php

namespace App\Http\Controllers\Rialchi;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class TrackingController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = $request->query();
        $searched = array_key_exists('number', $query);
        $number = is_string($query['number'] ?? null) ? strtoupper(trim($query['number'])) : '';
        $valid = $number !== '' && mb_strlen($number) <= 80;
        $shipment = $valid ? Shipment::with('events.status')->where('number', $number)->first() : null;

        return view('rialchi.pages.tracking', compact('number', 'searched', 'valid', 'shipment'));
    }
}
