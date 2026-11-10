<?php

namespace App\Http\Controllers\Rialchi;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class TrackingController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = $request->query();
        $searched = array_key_exists('number', $query);
        $number = is_string($query['number'] ?? null) ? trim($query['number']) : '';
        $valid = $number !== '' && mb_strlen($number) <= 80;
        $shipments = config('rialchi_tracking', []);
        $shipment = $searched && $valid ? ($shipments[strtoupper($number)] ?? null) : null;

        return view('rialchi.pages.tracking', compact('number', 'searched', 'valid', 'shipment'));
    }
}
