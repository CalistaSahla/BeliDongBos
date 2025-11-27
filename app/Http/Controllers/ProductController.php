<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $seller = Auth::user()->seller;
        $products = Product::where('seller_id', $seller->id)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'berat' => 'nullable|string|max:50',
            'kondisi' => 'required|in:baru,bekas',
            'min_pembelian' => 'nullable|string|max:10',
            'etalase' => 'nullable|string|max:100',
            'foto_utama' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_galeri.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'category_id.required' => 'Kategori wajib dipilih',
            'deskripsi.required' => 'Deskripsi produk wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'harga.min' => 'Harga tidak boleh negatif',
            'stok.required' => 'Stok wajib diisi',
            'stok.min' => 'Stok tidak boleh negatif',
            'foto_utama.required' => 'Foto utama wajib diupload',
            'foto_utama.image' => 'File harus berupa gambar',
            'foto_utama.max' => 'Ukuran file maksimal 2MB',
        ]);

        $seller = Auth::user()->seller;

        $fotoUtamaPath = $request->file('foto_utama')->store('products', 'public');

        $fotoGaleri = [];
        if ($request->hasFile('foto_galeri')) {
            foreach ($request->file('foto_galeri') as $file) {
                $fotoGaleri[] = $file->store('products', 'public');
            }
        }

        Product::create([
            'seller_id' => $seller->id,
            'category_id' => $validated['category_id'],
            'nama_produk' => $validated['nama_produk'],
            'slug' => Str::slug($validated['nama_produk']) . '-' . Str::random(5),
            'deskripsi' => $validated['deskripsi'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'berat' => $validated['berat'] ?? null,
            'kondisi' => $validated['kondisi'],
            'min_pembelian' => $validated['min_pembelian'] ?? '1',
            'etalase' => $validated['etalase'] ?? null,
            'foto_utama' => $fotoUtamaPath,
            'foto_galeri' => $fotoGaleri,
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $seller = Auth::user()->seller;
        
        if ($product->seller_id !== $seller->id) {
            abort(403);
        }

        $categories = Category::orderBy('name')->get();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $seller = Auth::user()->seller;
        
        if ($product->seller_id !== $seller->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'berat' => 'nullable|string|max:50',
            'kondisi' => 'required|in:baru,bekas',
            'min_pembelian' => 'nullable|string|max:10',
            'etalase' => 'nullable|string|max:100',
            'foto_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_galeri.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = [
            'category_id' => $validated['category_id'],
            'nama_produk' => $validated['nama_produk'],
            'deskripsi' => $validated['deskripsi'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'berat' => $validated['berat'] ?? null,
            'kondisi' => $validated['kondisi'],
            'min_pembelian' => $validated['min_pembelian'] ?? '1',
            'etalase' => $validated['etalase'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('foto_utama')) {
            if ($product->foto_utama) {
                Storage::disk('public')->delete($product->foto_utama);
            }
            $data['foto_utama'] = $request->file('foto_utama')->store('products', 'public');
        }

        if ($request->hasFile('foto_galeri')) {
            $fotoGaleri = $product->foto_galeri ?? [];
            foreach ($request->file('foto_galeri') as $file) {
                $fotoGaleri[] = $file->store('products', 'public');
            }
            $data['foto_galeri'] = $fotoGaleri;
        }

        $product->update($data);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $seller = Auth::user()->seller;
        
        if ($product->seller_id !== $seller->id) {
            abort(403);
        }

        if ($product->foto_utama) {
            Storage::disk('public')->delete($product->foto_utama);
        }

        if ($product->foto_galeri) {
            foreach ($product->foto_galeri as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
