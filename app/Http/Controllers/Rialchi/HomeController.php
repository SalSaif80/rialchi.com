<?php

namespace App\Http\Controllers\Rialchi;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

final class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('rialchi.pages.home');
    }
}
