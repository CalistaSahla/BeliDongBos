@extends('layouts.app')

@section('title', 'Ulasan ' . $product->nama_produk)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Katalog</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.show', $product->slug) }}">{{ Str::limit($product->nama_produk, 30) }}</a></li>
            <li class="breadcrumb-item active">Ulasan</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Semua Ulasan untuk {{ $product->nama_produk }}</h5>
            <small class="text-muted">Rating rata-rata: {{ number_format($product->rating_avg, 1) }} dari {{ $product->rating_count }} ulasan</small>
        </div>
        <div class="card-body">
            @if($ratings->count() > 0)
                @foreach($ratings as $rating)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $rating->nama }}</strong>
                                @if($rating->province)
                                    <small class="text-muted ms-2"><i class="bi bi-geo-alt"></i> {{ $rating->province->name }}</small>
                                @endif
                            </div>
                            <span class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $rating->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </span>
                        </div>
                        <small class="text-muted">{{ $rating->created_at->format('d M Y, H:i') }}</small>
                        <p class="mb-0 mt-2">{{ $rating->komentar }}</p>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center">
                    {{ $ratings->links() }}
                </div>
            @else
                <p class="text-muted text-center mb-0">Belum ada ulasan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
