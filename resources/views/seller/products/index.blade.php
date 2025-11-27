@extends('layouts.dashboard')

@section('title', 'Produk Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Produk Saya</h4>
    <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Produk
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($products->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            @if($product->foto_utama)
                                @if(str_starts_with($product->foto_utama, 'http'))
                                    <img src="{{ $product->foto_utama }}" width="50" height="50" class="rounded" style="object-fit: cover;">
                                @else
                                    <img src="{{ asset('storage/' . $product->foto_utama) }}" width="50" height="50" class="rounded" style="object-fit: cover;">
                                @endif
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('catalog.show', $product->slug) }}" target="_blank" class="text-decoration-none">
                                {{ Str::limit($product->nama_produk, 40) }}
                            </a>
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->formatted_harga }}</td>
                        <td>
                            @if($product->stok < 2)
                                <span class="badge bg-danger">{{ $product->stok }}</span>
                            @else
                                {{ $product->stok }}
                            @endif
                        </td>
                        <td>
                            <i class="bi bi-star-fill text-warning"></i> {{ number_format($product->rating_avg, 1) }}
                            <small class="text-muted">({{ $product->rating_count }})</small>
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
            <p class="text-muted mt-3">Anda belum memiliki produk.</p>
            <a href="{{ route('seller.products.create') }}" class="btn btn-primary">Tambah Produk Pertama</a>
        </div>
        @endif
    </div>
</div>
@endsection
