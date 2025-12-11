@extends('layouts.app')

@section('title', $product->nama_produk)

@push('styles')
<style>
    .zoomable-image {
        cursor: zoom-in;
        transition: opacity 0.2s;
    }
    .zoomable-image:hover {
        opacity: 0.9;
    }
    #imageZoomModal .modal-dialog {
        max-width: 90vw;
        margin: 1.75rem auto;
    }
    #imageZoomModal .modal-content {
        background: rgba(0, 0, 0, 0.95);
        border: none;
    }
    #imageZoomModal .modal-body {
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        overflow: hidden;
        position: relative;
    }
    #zoomImageContainer {
        overflow: hidden;
        width: 100%;
        height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: grab;
    }
    #zoomImageContainer.dragging {
        cursor: grabbing;
    }
    #zoomedImage {
        max-width: none;
        max-height: none;
        transition: transform 0.1s ease-out;
        user-select: none;
        -webkit-user-drag: none;
    }
    .zoom-controls {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 1060;
    }
    .zoom-controls button {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 2px solid #fff;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .zoom-controls button:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    #imageZoomModal .btn-close {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1060;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        padding: 10px;
        opacity: 1;
    }
    .zoom-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid #fff;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        font-size: 1.5rem;
        cursor: pointer;
        z-index: 1060;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .zoom-nav-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    .zoom-nav-prev { left: 15px; }
    .zoom-nav-next { right: 15px; }
    .zoom-indicator {
        position: absolute;
        top: 15px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        background: rgba(0, 0, 0, 0.7);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        z-index: 1060;
    }
</style>
@endpush

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
                                <img src="{{ $foto }}" class="d-block w-100 zoomable-image" alt="{{ $product->nama_produk }}" data-index="{{ $index }}" style="max-height: 400px; object-fit: contain; background: #f8f9fa;" onclick="openZoomModal({{ $index }})">
                            @elseif(str_starts_with($foto, '/'))
                                <img src="{{ asset($foto) }}" class="d-block w-100 zoomable-image" alt="{{ $product->nama_produk }}" data-index="{{ $index }}" style="max-height: 400px; object-fit: contain; background: #f8f9fa;" onclick="openZoomModal({{ $index }})">
                            @else
                                <img src="{{ asset('storage/' . $foto) }}" class="d-block w-100 zoomable-image" alt="{{ $product->nama_produk }}" data-index="{{ $index }}" style="max-height: 400px; object-fit: contain; background: #f8f9fa;" onclick="openZoomModal({{ $index }})">
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
                        @php
                            $thumbSrc = str_starts_with($foto, 'http') ? $foto : (str_starts_with($foto, '/') ? asset($foto) : asset('storage/' . $foto));
                        @endphp
                        <img src="{{ $thumbSrc }}" 
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
                                    @elseif(str_starts_with($related->foto_utama, '/'))
                                        <img src="{{ asset($related->foto_utama) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
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

<!-- Modal Zoom Image -->
<div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
                <div class="zoom-indicator">
                    <span id="currentImageIndex">1</span> / <span id="totalImages">{{ count($allPhotos ?? []) }}</span>
                </div>
                
                @if(isset($allPhotos) && count($allPhotos) > 1)
                <button class="zoom-nav-btn zoom-nav-prev" onclick="navigateZoom(-1)">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="zoom-nav-btn zoom-nav-next" onclick="navigateZoom(1)">
                    <i class="bi bi-chevron-right"></i>
                </button>
                @endif
                
                <div id="zoomImageContainer">
                    <img id="zoomedImage" src="" alt="Zoomed Image">
                </div>
                
                <div class="zoom-controls">
                    <button onclick="zoomIn()" title="Zoom In"><i class="bi bi-zoom-in"></i></button>
                    <button onclick="zoomOut()" title="Zoom Out"><i class="bi bi-zoom-out"></i></button>
                    <button onclick="resetZoom()" title="Reset"><i class="bi bi-arrows-angle-contract"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const productImages = @json($allPhotos ?? []);
    let currentZoomIndex = 0;
    let currentScale = 1;
    let translateX = 0;
    let translateY = 0;
    let isDragging = false;
    let startX, startY;
    
    const zoomModal = document.getElementById('imageZoomModal');
    const zoomedImage = document.getElementById('zoomedImage');
    const zoomContainer = document.getElementById('zoomImageContainer');
    
    function openZoomModal(index) {
        currentZoomIndex = index;
        updateZoomedImage();
        resetZoom();
        const modal = new bootstrap.Modal(zoomModal);
        modal.show();
    }
    
    function updateZoomedImage() {
        let src = productImages[currentZoomIndex];
        if (src.startsWith('http')) {
            // URL eksternal, gunakan langsung
        } else if (src.startsWith('/')) {
            // Path lokal seperti /images/xxx.webp - gunakan asset tanpa tambahan slash
            src = '{{ url("") }}' + src;
        } else {
            // Path storage seperti products/xxx.jpg
            src = '{{ asset("storage") }}/' + src;
        }
        zoomedImage.src = src;
        document.getElementById('currentImageIndex').textContent = currentZoomIndex + 1;
    }
    
    function navigateZoom(direction) {
        currentZoomIndex += direction;
        if (currentZoomIndex < 0) currentZoomIndex = productImages.length - 1;
        if (currentZoomIndex >= productImages.length) currentZoomIndex = 0;
        updateZoomedImage();
        resetZoom();
    }
    
    function zoomIn() {
        currentScale = Math.min(currentScale * 1.3, 5);
        applyTransform();
    }
    
    function zoomOut() {
        currentScale = Math.max(currentScale / 1.3, 0.5);
        applyTransform();
    }
    
    function resetZoom() {
        currentScale = 1;
        translateX = 0;
        translateY = 0;
        applyTransform();
    }
    
    function applyTransform() {
        zoomedImage.style.transform = `translate(${translateX}px, ${translateY}px) scale(${currentScale})`;
    }
    
    // Mouse drag for panning
    zoomContainer.addEventListener('mousedown', (e) => {
        if (currentScale > 1) {
            isDragging = true;
            startX = e.clientX - translateX;
            startY = e.clientY - translateY;
            zoomContainer.classList.add('dragging');
        }
    });
    
    document.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        translateX = e.clientX - startX;
        translateY = e.clientY - startY;
        applyTransform();
    });
    
    document.addEventListener('mouseup', () => {
        isDragging = false;
        zoomContainer.classList.remove('dragging');
    });
    
    // Mouse wheel zoom
    zoomContainer.addEventListener('wheel', (e) => {
        e.preventDefault();
        if (e.deltaY < 0) {
            zoomIn();
        } else {
            zoomOut();
        }
    });
    
    // Touch support for mobile
    let initialDistance = 0;
    let lastTouchX = 0;
    let lastTouchY = 0;
    
    zoomContainer.addEventListener('touchstart', (e) => {
        if (e.touches.length === 2) {
            initialDistance = getDistance(e.touches[0], e.touches[1]);
        } else if (e.touches.length === 1 && currentScale > 1) {
            isDragging = true;
            lastTouchX = e.touches[0].clientX;
            lastTouchY = e.touches[0].clientY;
        }
    });
    
    zoomContainer.addEventListener('touchmove', (e) => {
        e.preventDefault();
        if (e.touches.length === 2) {
            const newDistance = getDistance(e.touches[0], e.touches[1]);
            const scale = newDistance / initialDistance;
            currentScale = Math.min(Math.max(currentScale * scale, 0.5), 5);
            initialDistance = newDistance;
            applyTransform();
        } else if (e.touches.length === 1 && isDragging) {
            const deltaX = e.touches[0].clientX - lastTouchX;
            const deltaY = e.touches[0].clientY - lastTouchY;
            translateX += deltaX;
            translateY += deltaY;
            lastTouchX = e.touches[0].clientX;
            lastTouchY = e.touches[0].clientY;
            applyTransform();
        }
    });
    
    zoomContainer.addEventListener('touchend', () => {
        isDragging = false;
        initialDistance = 0;
    });
    
    function getDistance(touch1, touch2) {
        return Math.hypot(touch2.clientX - touch1.clientX, touch2.clientY - touch1.clientY);
    }
    
    // Keyboard navigation
    zoomModal.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') navigateZoom(-1);
        if (e.key === 'ArrowRight') navigateZoom(1);
        if (e.key === '+' || e.key === '=') zoomIn();
        if (e.key === '-') zoomOut();
        if (e.key === '0') resetZoom();
        if (e.key === 'Escape') bootstrap.Modal.getInstance(zoomModal).hide();
    });
    
    // Reset zoom when modal closes
    zoomModal.addEventListener('hidden.bs.modal', () => {
        resetZoom();
    });
    
    // Double click to zoom
    zoomedImage.addEventListener('dblclick', () => {
        if (currentScale > 1) {
            resetZoom();
        } else {
            currentScale = 2;
            applyTransform();
        }
    });
</script>
@endpush
