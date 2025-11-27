<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlatformMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isPlatform()) {
            abort(403, 'Akses ditolak. Hanya admin platform yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
