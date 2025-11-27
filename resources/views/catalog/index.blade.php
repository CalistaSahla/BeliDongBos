@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><strong>Filter Produk</strong></div>
                <div class="card-body">
                    <form action="{{ route('catalog.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Provinsi</label>
                            <select name="province_id" class="form-select form-select-sm">
                                <option value="">Semua Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urutkan</label>
                            <select name="sort" class="form-select form-select-sm">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            </select>
                        </div>
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm w-100">Terapkan Filter</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            @if(request('search'))
                <p class="text-muted mb-3">Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong></p>
            @endif
            
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card product-card h-100 shadow-sm">
                                <a href="{{ route('catalog.show', $product->slug) }}">
                                    @if($product->foto_utama)
                                        @if(str_starts_with($product->foto_utama, 'http'))
                                            <img src="{{ $product->foto_utama }}" class="card-img-top product-image" alt="{{ $product->nama_produk }}">
                                        @else
                                            <img src="{{ asset('storage/' . $product->foto_utama) }}" class="card-img-top product-image" alt="{{ $product->nama_produk }}">
                                        @endif
                                    @else
                                        <div class="card-img-top product-image bg-light d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                </a>
                                <div class="card-body">
                                    <a href="{{ route('catalog.show', $product->slug) }}" class="text-decoration-none text-dark">
                                        <h6 class="card-title text-truncate">{{ $product->nama_produk }}</h6>
                                    </a>
                                    <p class="text-primary fw-bold mb-1">{{ $product->formatted_harga }}</p>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= round($product->rating_avg) ? '-fill' : '' }}"></i>
                                            @endfor
                                        </span>
                                        <small class="text-muted ms-1">({{ $product->rating_count }})</small>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-shop"></i> 
                                        <a href="{{ route('catalog.seller', $product->seller->id) }}" class="text-decoration-none text-muted">
                                            {{ $product->seller->nama_toko }}
                                        </a>
                                    </small><br>
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt"></i> {{ $product->seller->city->name ?? '' }}, {{ $product->seller->province->name ?? '' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">Tidak ada produk ditemukan.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
