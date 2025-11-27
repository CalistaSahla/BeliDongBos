<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isSeller()) {
            abort(403, 'Akses ditolak. Hanya penjual yang dapat mengakses halaman ini.');
        }

        $seller = $request->user()->seller;
        if (!$seller || $seller->status !== 'approved' || !$seller->is_active) {
            abort(403, 'Akun penjual Anda belum diverifikasi atau tidak aktif.');
        }

        return $next($request);
    }
}
