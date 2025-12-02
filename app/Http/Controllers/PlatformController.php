<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Category;
use App\Models\Province;
use App\Mail\SellerApproved;
use App\Mail\SellerRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PlatformController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_sellers' => Seller::count(),
            'active_sellers' => Seller::where('is_active', true)->where('status', 'approved')->count(),
            'inactive_sellers' => Seller::where('is_active', false)->orWhere('status', '!=', 'approved')->count(),
            'pending_sellers' => Seller::where('status', 'pending')->count(),
            'total_products' => Product::count(),
            'total_ratings' => Rating::count(),
        ];

        $productsPerCategory = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get()
            ->map(fn($c) => ['name' => $c->name, 'count' => $c->products_count]);

        $sellersPerProvince = Province::withCount(['sellers' => function($q) {
                $q->where('status', 'approved');
            }])
            ->orderBy('sellers_count', 'desc')
            ->limit(10)
            ->get()
            ->map(fn($p) => ['name' => $p->name, 'count' => $p->sellers_count]);

        $ratingsCount = Rating::count();

        return view('platform.dashboard', compact('stats', 'productsPerCategory', 'sellersPerProvince', 'ratingsCount'));
    }

    public function pendingSellers()
    {
        $sellers = Seller::with(['province', 'city', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('platform.pending-sellers', compact('sellers'));
    }

    public function showSeller(Seller $seller)
    {
        $seller->load(['province', 'city', 'user', 'products']);
        return view('platform.seller-detail', compact('seller'));
    }

    public function approveSeller(Request $request, Seller $seller)
    {
        $seller->update([
            'status' => 'approved',
        ]);

        Mail::to($seller->email)->send(new SellerApproved($seller));

        return redirect()->route('platform.pending-sellers')
            ->with('success', 'Penjual berhasil disetujui. Email aktivasi telah dikirim.');
    }

    public function rejectSeller(Request $request, Seller $seller)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $seller->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        Mail::to($seller->email)->send(new SellerRejected($seller));

        return redirect()->route('platform.pending-sellers')
            ->with('success', 'Penjual berhasil ditolak. Email pemberitahuan telah dikirim.');
    }

    public function allSellers(Request $request)
    {
        $query = Seller::with(['province', 'city', 'user'])
            ->withCount('products');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->province_id) {
            $query->where('province_id', $request->province_id);
        }

        $sellers = $query->orderBy('created_at', 'desc')->paginate(15);
        $provinces = Province::orderBy('name')->get();

        return view('platform.all-sellers', compact('sellers', 'provinces'));
    }
}
