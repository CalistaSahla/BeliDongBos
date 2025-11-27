<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use App\Mail\RatingThankYou;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RatingController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nomor_hp' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
            'province_id' => 'nullable|exists:provinces,id',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nomor_hp.required' => 'Nomor HP wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'rating.required' => 'Rating wajib dipilih',
            'rating.min' => 'Rating minimal 1',
            'rating.max' => 'Rating maksimal 5',
            'komentar.required' => 'Komentar wajib diisi',
        ]);

        $rating = Rating::create([
            'product_id' => $product->id,
            'nama' => $validated['nama'],
            'nomor_hp' => $validated['nomor_hp'],
            'email' => $validated['email'],
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar'],
            'province_id' => $validated['province_id'] ?? null,
        ]);

        Mail::to($validated['email'])->send(new RatingThankYou($rating, $product));

        return redirect()->back()
            ->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }

    public function productRatings(Product $product)
    {
        $ratings = Rating::where('product_id', $product->id)
            ->with('province')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('catalog.ratings', compact('product', 'ratings'));
    }
}
