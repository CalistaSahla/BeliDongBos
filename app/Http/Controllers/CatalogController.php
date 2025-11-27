<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Province;
use App\Models\Seller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $this->logVisitor($request, 'catalog');

        $query = Product::with(['seller.province', 'seller.city', 'category'])
            ->where('is_active', true)
            ->whereHas('seller', function ($q) {
                $q->where('is_active', true)->where('status', 'approved');
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('seller', function ($sq) use ($search) {
                      $sq->where('nama_toko', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('province_id')) {
            $query->whereHas('seller', function ($q) use ($request) {
                $q->where('province_id', $request->province_id);
            });
        }

        if ($request->filled('city_id')) {
            $query->whereHas('seller', function ($q) use ($request) {
                $q->where('city_id', $request->city_id);
            });
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('harga', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('harga', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('rating_avg', 'desc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();

        return view('catalog.index', compact('products', 'categories', 'provinces'));
    }

    public function show(Request $request, $slug)
    {
        $this->logVisitor($request, 'product/' . $slug);

        $product = Product::with(['seller.province', 'seller.city', 'category', 'ratings' => function ($q) {
            $q->orderBy('created_at', 'desc')->limit(10);
        }])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->whereHas('seller', function ($q) {
                $q->where('is_active', true)->where('status', 'approved');
            })
            ->firstOrFail();

        $relatedProducts = Product::with(['seller.province', 'category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        $provinces = Province::orderBy('name')->get();

        return view('catalog.show', compact('product', 'relatedProducts', 'provinces'));
    }

    public function seller(Request $request, $id)
    {
        $this->logVisitor($request, 'seller/' . $id);

        $seller = Seller::with(['province', 'city'])
            ->where('id', $id)
            ->where('is_active', true)
            ->where('status', 'approved')
            ->firstOrFail();

        $products = Product::with(['category'])
            ->where('seller_id', $seller->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('catalog.seller', compact('seller', 'products'));
    }

    private function logVisitor(Request $request, $page)
    {
        VisitorLog::create([
            'ip_address' => $request->ip(),
            'user_agent' => substr($request->userAgent() ?? '', 0, 500),
            'page_visited' => $page,
            'visited_at' => now(),
        ]);
    }
}
