<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    public function dashboard()
    {
        $seller = Auth::user()->seller;
        
        $stats = [
            'total_products' => $seller->products()->count(),
            'total_stock' => $seller->products()->sum('stok'),
            'low_stock' => $seller->products()->where('stok', '<', 2)->count(),
            'total_ratings' => Rating::whereHas('product', function ($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })->count(),
            'avg_rating' => Rating::whereHas('product', function ($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })->avg('rating') ?? 0,
        ];

        $stockDistribution = $seller->products()
            ->select('nama_produk', 'stok')
            ->orderBy('stok', 'desc')
            ->limit(10)
            ->get()
            ->map(fn($p) => ['name' => $p->nama_produk, 'stock' => $p->stok]);

        $ratingPerProduct = $seller->products()
            ->select('nama_produk', 'rating_avg', 'rating_count')
            ->where('rating_count', '>', 0)
            ->orderBy('rating_avg', 'desc')
            ->limit(10)
            ->get()
            ->map(fn($p) => [
                'name' => $p->nama_produk,
                'rating' => round($p->rating_avg, 1),
                'count' => $p->rating_count
            ]);

        $ratingByProvince = Rating::selectRaw('provinces.name as province_name, COUNT(*) as rating_count, AVG(ratings.rating) as avg_rating')
            ->join('provinces', 'ratings.province_id', '=', 'provinces.id')
            ->whereHas('product', function ($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })
            ->groupBy('provinces.id', 'provinces.name')
            ->orderBy('rating_count', 'desc')
            ->limit(10)
            ->get()
            ->map(fn($r) => [
                'province' => $r->province_name,
                'count' => $r->rating_count,
                'avg' => round($r->avg_rating, 1)
            ]);

        return view('seller.dashboard', compact('stats', 'stockDistribution', 'ratingPerProduct', 'ratingByProvince'));
    }
}
