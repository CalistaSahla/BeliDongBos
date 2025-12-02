@extends('layouts.dashboard')

@section('title', 'Tambah Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Tambah Produk Baru</h4>
    <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <strong>Error!</strong> Periksa kembali inputan Anda.
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="formProduk">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" 
                            value="{{ old('nama_produk') }}" required>
                        @error('nama_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                            rows="5" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                                value="{{ old('harga') }}" min="0" required>
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" 
                                value="{{ old('stok', 0) }}" min="0" required>
                            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Berat</label>
                            <input type="text" name="berat" class="form-control" value="{{ old('berat') }}" 
                                placeholder="contoh: 500 gram">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                            <select name="kondisi" class="form-select" required>
                                <option value="baru" {{ old('kondisi') == 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="bekas" {{ old('kondisi') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Etalase</label>
                        <input type="text" name="etalase" class="form-control" value="{{ old('etalase') }}" 
                            placeholder="contoh: Elektronik, Aksesoris">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Foto Utama <span class="text-danger">*</span></label>
                        <input type="file" name="foto_utama" class="form-control @error('foto_utama') is-invalid @enderror" 
                            accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                        @error('foto_utama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Galeri (Opsional)</label>
                        <input type="file" name="foto_galeri[]" class="form-control" accept="image/*" multiple>
                        <small class="text-muted">Bisa upload beberapa foto</small>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary" id="btnSimpan">
                <i class="bi bi-check-circle"></i> Simpan Produk
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('formProduk').addEventListener('submit', function(e) {
    var btn = document.getElementById('btnSimpan');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
});
</script>
@endpush
