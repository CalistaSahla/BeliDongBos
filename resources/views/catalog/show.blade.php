@extends('layouts.app')

@section('title', $product->nama_produk)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Katalog</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index', ['category_id' => $product->category_id]) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($product->nama_produk, 30) }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-5">
            @php
                $allPhotos = [];
                if($product->foto_utama) {
                    $allPhotos[] = $product->foto_utama;
                }
                if($product->foto_galeri && count($product->foto_galeri) > 0) {
                    $allPhotos = array_merge($allPhotos, $product->foto_galeri);
                }
            @endphp
            
            @if(count($allPhotos) > 0)
            <div id="productCarousel" class="carousel slide card shadow-sm" data-bs-ride="false">
                <div class="carousel-indicators">
                    @foreach($allPhotos as $index => $foto)
                        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="{{ $index }}" 
                            class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach($allPhotos as $index => $foto)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            @if(str_starts_with($foto, 'http'))
                                <img src="{{ $foto }}" class="d-block w-100" alt="{{ $product->nama_produk }}" style="max-height: 400px; object-fit: contain; background: #f8f9fa;">
                            @else
                                <img src="{{ asset('storage/' . $foto) }}" class="d-block w-100" alt="{{ $product->nama_produk }}" style="max-height: 400px; object-fit: contain; background: #f8f9fa;">
                            @endif
                        </div>
                    @endforeach
                </div>
                @if(count($allPhotos) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" style="width: 40px;">
                    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.6); border-radius: 50%; padding: 10px; width: 30px; height: 30px;"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next" style="width: 40px;">
                    <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.6); border-radius: 50%; padding: 10px; width: 30px; height: 30px;"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                @endif
            </div>
            
            @if(count($allPhotos) > 1)
            <div class="row mt-2">
                @foreach($allPhotos as $index => $foto)
                    <div class="col-3 mb-2">
                        <img src="{{ str_starts_with($foto, 'http') ? $foto : asset('storage/' . $foto) }}" 
                            class="img-thumbnail thumbnail-nav" 
                            alt="Thumbnail {{ $index + 1 }}"
                            data-bs-target="#productCarousel" 
                            data-bs-slide-to="{{ $index }}"
                            style="cursor: pointer; height: 70px; object-fit: cover; {{ $index == 0 ? 'border: 3px solid var(--retro-purple);' : '' }}"
                            onclick="document.querySelectorAll('.thumbnail-nav').forEach(t => t.style.border = ''); this.style.border = '3px solid var(--retro-purple)';">
                    </div>
                @endforeach
            </div>
            @endif
            @else
            <div class="card shadow-sm">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-7">
            <h4>{{ $product->nama_produk }}</h4>
            <div class="d-flex align-items-center mb-2">
                <span class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= round($product->rating_avg) ? '-fill' : '' }}"></i>
                    @endfor
                </span>
                <span class="ms-2">{{ number_format($product->rating_avg, 1) }}</span>
                <span class="text-muted ms-1">({{ $product->rating_count }} ulasan)</span>
            </div>
            <h3 class="text-primary fw-bold">{{ $product->formatted_harga }}</h3>
            
            <hr>
            
            <table class="table table-sm">
                <tr><td class="text-muted" width="150">Kondisi</td><td>{{ ucfirst($product->kondisi) }}</td></tr>
                <tr><td class="text-muted">Stok</td><td>{{ $product->stok }} pcs</td></tr>
                <tr><td class="text-muted">Berat</td><td>{{ $product->berat ?? '-' }}</td></tr>

                <tr><td class="text-muted">Kategori</td><td>{{ $product->category->name }}</td></tr>
                @if($product->etalase)
                <tr><td class="text-muted">Etalase</td><td>{{ $product->etalase }}</td></tr>
                @endif
            </table>

            <hr>
            
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shop fs-1 text-primary me-3"></i>
                        <div>
                            <h6 class="mb-0">
                                <a href="{{ route('catalog.seller', $product->seller->id) }}" class="text-decoration-none">
                                    {{ $product->seller->nama_toko }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="bi bi-geo-alt"></i> {{ $product->seller->city->name ?? '' }}, {{ $product->seller->province->name ?? '' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><strong>Deskripsi Produk</strong></div>
                <div class="card-body">
                    {!! nl2br(e($product->deskripsi)) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><strong>Ulasan Produk ({{ $product->rating_count }})</strong></div>
                <div class="card-body">
                    @if($product->ratings->count() > 0)
                        @foreach($product->ratings as $rating)
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $rating->nama }}</strong>
                                    <span class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $rating->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </span>
                                </div>
                                <small class="text-muted">{{ $rating->created_at->format('d M Y') }}</small>
                                <p class="mb-0 mt-2">{{ $rating->komentar }}</p>
                            </div>
                        @endforeach
                        @if($product->rating_count > 10)
                            <a href="{{ route('catalog.ratings', $product) }}" class="btn btn-outline-primary btn-sm">
                                Lihat Semua Ulasan
                            </a>
                        @endif
                    @else
                        <p class="text-muted mb-0">Belum ada ulasan untuk produk ini.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><strong>Tulis Ulasan</strong></div>
                <div class="card-body">
                    <form action="{{ route('rating.store', $product) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror" value="{{ old('nomor_hp') }}" required>
                                @error('nomor_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi Anda</label>
                            <select name="province_id" class="form-select">
                                <option value="">Pilih Provinsi (opsional)</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rating <span class="text-danger">*</span></label>
                            <div class="rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="rating{{ $i }}">{{ $i }} <i class="bi bi-star-fill text-warning"></i></label>
                                    </div>
                                @endfor
                            </div>
                            @error('rating')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Komentar <span class="text-danger">*</span></label>
                            <textarea name="komentar" class="form-control @error('komentar') is-invalid @enderror" rows="3" required>{{ old('komentar') }}</textarea>
                            @error('komentar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <h5>Produk Serupa</h5>
            <div class="row">
                @foreach($relatedProducts as $related)
                    <div class="col-md-3 mb-3">
                        <div class="card product-card h-100 shadow-sm">
                            <a href="{{ route('catalog.show', $related->slug) }}">
                                @if($related->foto_utama)
                                    @if(str_starts_with($related->foto_utama, 'http'))
                                        <img src="{{ $related->foto_utama }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('storage/' . $related->foto_utama) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    @endif
                                @endif
                            </a>
                            <div class="card-body">
                                <a href="{{ route('catalog.show', $related->slug) }}" class="text-decoration-none text-dark">
                                    <h6 class="card-title text-truncate">{{ $related->nama_produk }}</h6>
                                </a>
                                <p class="text-primary fw-bold mb-0">{{ $related->formatted_harga }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
