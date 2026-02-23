<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->query('lang');

        if ($locale && in_array(strtolower(substr($locale, 0, 2)), ['en', 'ar'])) {
            $locale = strtolower(substr($locale, 0, 2));
            if ($request->hasSession()) {
                $request->session()->put('locale', $locale);
            }
        }

        if (!$locale && $request->hasSession()) {
            $locale = $request->session()->get('locale');
        }

        if (!$locale) {
            $locale = $request->header('Accept-Language');
        }

        if (!$locale) {
            $locale = config('app.locale');
        }

        // Extract first two characters (e.g., 'en-US' -> 'en')
        $locale = strtolower(substr($locale ?? 'en', 0, 2));

        if (in_array($locale, ['en', 'ar'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
