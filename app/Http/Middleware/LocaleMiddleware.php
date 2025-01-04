<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }

        $locale = session('locale', config('app.locale'));
        app()->setLocale($locale);


    \Log::info("Current locale is: " . app()->getLocale());
    \Log::info("Locale set to: " . session()->get('locale'));
    \Log::info('Locale applied: ' . app()->getLocale());
        return $next($request);
    }
}
