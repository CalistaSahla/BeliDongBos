@extends('layouts.dashboard')

@section('title', 'Edit Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Edit Produk</h4>
    <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" 
                            value="{{ old('nama_produk', $product->nama_produk) }}" required>
                        @error('nama_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                            rows="5" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                                value="{{ old('harga', $product->harga) }}" min="0" required>
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" 
                                value="{{ old('stok', $product->stok) }}" min="0" required>
                            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Berat</label>
                            <input type="text" name="berat" class="form-control" value="{{ old('berat', $product->berat) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                            <select name="kondisi" class="form-select" required>
                                <option value="baru" {{ old('kondisi', $product->kondisi) == 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="bekas" {{ old('kondisi', $product->kondisi) == 'bekas' ? 'selected' : '' }}>Bekas</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Etalase</label>
                        <input type="text" name="etalase" class="form-control" value="{{ old('etalase', $product->etalase) }}">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" 
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label">Produk Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Foto Utama Saat Ini</label>
                        @if($product->foto_utama)
                            <img src="{{ asset('storage/' . $product->foto_utama) }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                        @endif
                        <input type="file" name="foto_utama" class="form-control @error('foto_utama') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                        @error('foto_utama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Galeri Saat Ini</label>
                        @if($product->foto_galeri && count($product->foto_galeri) > 0)
                            <div class="row mb-2">
                                @foreach($product->foto_galeri as $foto)
                                    <div class="col-4 mb-2">
                                        <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail" style="height: 60px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <input type="file" name="foto_galeri[]" class="form-control" accept="image/*" multiple>
                        <small class="text-muted">Tambah foto baru (tidak menghapus yang lama)</small>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Update Produk
            </button>
        </form>
    </div>
</div>
@endsection
