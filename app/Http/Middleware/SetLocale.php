<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $supported = ['ar', 'en', 'zh_CN'];
        $selected = $request->query('locale');
        if (is_string($selected) && in_array($selected, $supported, true)) {
            $request->session()->put('locale', $selected);
        }
        $locale = $request->session()->get('locale', 'ar');
        app()->setLocale(in_array($locale, $supported, true) ? $locale : 'ar');

        return $next($request);
    }
}
