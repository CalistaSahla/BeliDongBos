@extends('layouts.app')

@section('title', $seller->nama_toko)

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-shop text-primary" style="font-size: 4rem;"></i>
                </div>
                <div class="col">
                    <h4 class="mb-1">{{ $seller->nama_toko }}</h4>
                    <p class="text-muted mb-1">
                        <i class="bi bi-geo-alt"></i> {{ $seller->city->name ?? '' }}, {{ $seller->province->name ?? '' }}
                    </p>
                    <p class="text-muted mb-0">
                        <i class="bi bi-box-seam"></i> {{ $products->total() }} Produk
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mb-3">Produk dari {{ $seller->nama_toko }}</h5>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
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
                            <div class="d-flex align-items-center">
                                <span class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= round($product->rating_avg) ? '-fill' : '' }}"></i>
                                    @endfor
                                </span>
                                <small class="text-muted ms-1">({{ $product->rating_count }})</small>
                            </div>
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
            <p class="text-muted mt-3">Toko ini belum memiliki produk.</p>
        </div>
    @endif
</div>
@endsection
