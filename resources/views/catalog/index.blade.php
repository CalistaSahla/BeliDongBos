@extends('layouts.app')

@section('title', 'Katalog Produk')

@push('styles')
<style>
    .hero-billboard {
        background: linear-gradient(135deg, var(--retro-purple) 0%, var(--retro-teal) 50%, var(--retro-blue) 100%);
        border: 4px solid #333;
        box-shadow: 8px 8px 0 #333;
        border-radius: 0;
        overflow: hidden;
        position: relative;
    }
    .hero-billboard::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }
    .hero-content {
        position: relative;
        z-index: 1;
    }
    .hero-title {
        font-family: 'Pixelify Sans', sans-serif;
        color: var(--retro-yellow);
        text-shadow: 4px 4px 0 #333, -1px -1px 0 #333, 1px -1px 0 #333, -1px 1px 0 #333;
        font-size: 2.5rem;
    }
    .hero-subtitle {
        color: #fff;
        text-shadow: 2px 2px 0 #333;
    }
    .hero-badge {
        display: inline-block;
        background: var(--retro-yellow);
        color: #333;
        padding: 5px 15px;
        border: 3px solid #333;
        box-shadow: 3px 3px 0 #333;
        font-weight: bold;
        transform: rotate(-3deg);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: rotate(-3deg) scale(1); }
        50% { transform: rotate(-3deg) scale(1.05); }
    }
    .category-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
    }
    .category-pill {
        background: #fff;
        border: 2px solid #333;
        padding: 6px 14px;
        font-size: 0.85rem;
        font-weight: bold;
        color: #333;
        text-decoration: none;
        box-shadow: 3px 3px 0 #333;
        transition: all 0.2s;
    }
    .category-pill:hover {
        background: var(--retro-yellow);
        transform: translate(2px, 2px);
        box-shadow: 1px 1px 0 #333;
        color: #333;
    }
    .category-pill.active {
        background: var(--retro-purple);
        color: #fff;
    }
    .floating-emoji {
        position: absolute;
        font-size: 2rem;
        opacity: 0.3;
        animation: float 3s ease-in-out infinite;
    }
    .floating-emoji:nth-child(1) { top: 10%; left: 5%; animation-delay: 0s; }
    .floating-emoji:nth-child(2) { top: 20%; right: 8%; animation-delay: 0.5s; }
    .floating-emoji:nth-child(3) { bottom: 15%; left: 10%; animation-delay: 1s; }
    .floating-emoji:nth-child(4) { bottom: 25%; right: 5%; animation-delay: 1.5s; }
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(10deg); }
    }
</style>
@endpush

@section('content')
<!-- Hero Billboard -->
<div class="hero-billboard mb-4">
    <div class="floating-emoji">🛍️</div>
    <div class="floating-emoji">⭐</div>
    <div class="floating-emoji">✨</div>
    <div class="floating-emoji">🎉</div>
    <div class="container py-5">
        <div class="hero-content text-center">
            <span class="hero-badge mb-3">✨ KATALOG PRODUK</span>
            <h1 class="hero-title mb-3">Selamat Datang di BeliDongBos!</h1>
            <p class="hero-subtitle fs-5 mb-4">
                Jelajahi berbagai produk menarik dari penjual di seluruh Indonesia.
                <br>Temukan inspirasi dan lihat koleksi terbaik kami!
            </p>
            <a href="#products" class="btn btn-primary btn-lg">
                <i class="bi bi-eye"></i> Lihat Produk
            </a>
        </div>
    </div>
</div>

<!-- Category Quick Access -->
<div class="container mb-4">
    <div class="category-pills">
        <a href="{{ route('catalog.index') }}" class="category-pill {{ !request('category_id') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i> Semua
        </a>
        @foreach($categories->take(8) as $cat)
            <a href="{{ route('catalog.index', ['category_id' => $cat->id]) }}" 
               class="category-pill {{ request('category_id') == $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</div>

<div class="container py-4" id="products">
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
                            <select name="province_id" id="province_id" class="form-select form-select-sm">
                                <option value="">Semua Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kota/Kabupaten</label>
                            <select name="city_id" id="city_id" class="form-select form-select-sm">
                                <option value="">Semua Kota</option>
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
                                        @elseif(str_starts_with($product->foto_utama, '/'))
                                            <img src="{{ asset($product->foto_utama) }}" class="card-img-top product-image" alt="{{ $product->nama_produk }}">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const currentCityId = '{{ request('city_id') }}';
    
    function loadCities(provinceId, selectedCityId = null) {
        if (!provinceId) {
            citySelect.innerHTML = '<option value="">Semua Kota</option>';
            return;
        }
        
        citySelect.innerHTML = '<option value="">Memuat...</option>';
        
        fetch(`/api/cities?province_id=${provinceId}`)
            .then(response => response.json())
            .then(cities => {
                citySelect.innerHTML = '<option value="">Semua Kota</option>';
                cities.forEach(city => {
                    const selected = selectedCityId && city.id == selectedCityId ? 'selected' : '';
                    citySelect.innerHTML += `<option value="${city.id}" ${selected}>${city.name}</option>`;
                });
            });
    }
    
    // Load cities if province is already selected
    if (provinceSelect.value) {
        loadCities(provinceSelect.value, currentCityId);
    }
    
    // Load cities when province changes
    provinceSelect.addEventListener('change', function() {
        loadCities(this.value);
    });
});
</script>
@endpush