<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Product;
use App\Models\Province;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('platform.reports.index');
    }

    public function sellersActiveInactive()
    {
        $activeSellers = Seller::with(['province', 'city'])
            ->where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('nama_toko')
            ->get();

        $inactiveSellers = Seller::with(['province', 'city'])
            ->where(function ($q) {
                $q->where('is_active', false)
                  ->orWhere('status', '!=', 'approved');
            })
            ->orderBy('nama_toko')
            ->get();

        $pdf = Pdf::loadView('platform.reports.sellers-active-inactive', [
            'activeSellers' => $activeSellers,
            'inactiveSellers' => $inactiveSellers,
            'generatedAt' => now()->format('d/m/Y H:i'),
        ]);

        return $pdf->download('laporan-penjual-aktif-tidak-aktif.pdf');
    }

    public function sellersByProvince()
    {
        $provinces = Province::with(['sellers' => function ($q) {
            $q->where('status', 'approved')->with('city')->orderBy('nama_toko');
        }])
            ->whereHas('sellers', function ($q) {
                $q->where('status', 'approved');
            })
            ->orderBy('name')
            ->get();

        $pdf = Pdf::loadView('platform.reports.sellers-by-province', [
            'provinces' => $provinces,
            'generatedAt' => now()->format('d/m/Y H:i'),
        ]);

        return $pdf->download('laporan-penjual-per-provinsi.pdf');
    }

    public function productsByRating()
    {
        $products = Product::with(['seller.province', 'category'])
            ->where('is_active', true)
            ->where('rating_count', '>', 0)
            ->orderBy('rating_avg', 'desc')
            ->get();

        $pdf = Pdf::loadView('platform.reports.products-by-rating', [
            'products' => $products,
            'generatedAt' => now()->format('d/m/Y H:i'),
        ]);

        return $pdf->download('laporan-produk-rating-tertinggi.pdf');
    }

    public function productsByStock()
    {
        $products = Product::with(['seller.province', 'category'])
            ->where('is_active', true)
            ->orderBy('stok', 'desc')
            ->get();

        $pdf = Pdf::loadView('platform.reports.products-by-stock', [
            'products' => $products,
            'generatedAt' => now()->format('d/m/Y H:i'),
        ]);

        return $pdf->download('laporan-stok-produk-tertinggi.pdf');
    }

    public function productsByStockAndRating()
    {
        $products = Product::with(['seller.province', 'category'])
            ->where('is_active', true)
            ->orderBy('rating_avg', 'desc')
            ->orderBy('stok', 'desc')
            ->get();

        $pdf = Pdf::loadView('platform.reports.products-by-stock-rating', [
            'products' => $products,
            'generatedAt' => now()->format('d/m/Y H:i'),
        ]);

        return $pdf->download('laporan-stok-produk-berdasarkan-rating.pdf');
    }

    public function productsNeedRestock()
    {
        $products = Product::with(['seller.province', 'category'])
            ->where('is_active', true)
            ->where('stok', '<', 2)
            ->orderBy('stok', 'asc')
            ->orderBy('nama_produk', 'asc')
            ->get();

        $pdf = Pdf::loadView('platform.reports.products-need-restock', [
            'products' => $products,
            'generatedAt' => now()->format('d/m/Y H:i'),
        ]);

        return $pdf->download('laporan-produk-perlu-restock.pdf');
    }
}
