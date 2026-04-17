<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSpecialist
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->type === 'specialist') {
            return $next($request);
        }

        return response()->json([
            'message' => 'Access denied. Specialists only.',
        ], 403);
    }
}
