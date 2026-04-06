<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class setLang
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Accept-Language')
            ?? $request->query('lang')
            ?? session('lang')
            ?? config('app.locale');

        // Clean and confirm language
        $locale = substr($locale, 0, 2);  // Take first two characters
        $supportedLocales = ['en', 'ar'];

        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
            session(['lang' => $locale]);
        }

        return $next($request);
    }
}
