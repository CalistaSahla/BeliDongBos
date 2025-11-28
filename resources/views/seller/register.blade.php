@extends('layouts.app')

@section('title', 'Daftar Penjual')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-shop"></i> Daftar Menjadi Penjual</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('seller.register') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <h6 class="text-muted mb-3">Informasi Toko</h6>
                        
                        <div class="mb-3">
                            <label for="nama_toko" class="form-label">Nama Toko <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_toko') is-invalid @enderror" 
                                id="nama_toko" name="nama_toko" value="{{ old('nama_toko') }}" required>
                            @error('nama_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi_singkat') is-invalid @enderror" 
                                id="deskripsi_singkat" name="deskripsi_singkat" rows="2" maxlength="500" required>{{ old('deskripsi_singkat') }}</textarea>
                            <small class="text-muted">Maksimal 500 karakter</small>
                            @error('deskripsi_singkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="province_id" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <select class="form-select @error('province_id') is-invalid @enderror" 
                                    id="province_id" name="province_id" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                                <select class="form-select @error('city_id') is-invalid @enderror" 
                                    id="city_id" name="city_id" required>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                                @error('city_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat_toko" class="form-label">Alamat Lengkap Toko <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat_toko') is-invalid @enderror" 
                                id="alamat_toko" name="alamat_toko" rows="2" required>{{ old('alamat_toko') }}</textarea>
                            @error('alamat_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('rt') is-invalid @enderror" 
                                    id="rt" name="rt" value="{{ old('rt') }}" maxlength="10" required>
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('rw') is-invalid @enderror" 
                                    id="rw" name="rw" value="{{ old('rw') }}" maxlength="10" required>
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="village_id" class="form-label">Kelurahan <span class="text-danger">*</span></label>
                                <select class="form-select @error('village_id') is-invalid @enderror" 
                                    id="village_id" name="village_id" required>
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                                @error('village_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-muted mb-3">Informasi PIC (Person In Charge)</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_pic" class="form-label">Nama PIC <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_pic') is-invalid @enderror" 
                                    id="nama_pic" name="nama_pic" value="{{ old('nama_pic') }}" required>
                                @error('nama_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kontak_pic" class="form-label">Kontak PIC <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kontak_pic') is-invalid @enderror" 
                                    id="kontak_pic" name="kontak_pic" value="{{ old('kontak_pic') }}" required>
                                @error('kontak_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nomor_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" 
                                    id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" required>
                                @error('nomor_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="no_ktp" class="form-label">No. KTP PIC <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_ktp') is-invalid @enderror" 
                                id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}" maxlength="20" required>
                            @error('no_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="foto_pic" class="form-label">Foto PIC <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('foto_pic') is-invalid @enderror" 
                                    id="foto_pic" name="foto_pic" accept="image/*" required>
                                <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                @error('foto_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="foto_ktp" class="form-label">File Upload KTP PIC <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('foto_ktp') is-invalid @enderror" 
                                    id="foto_ktp" name="foto_ktp" accept="image/*" required>
                                <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                @error('foto_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-muted mb-3">Informasi Akun</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" 
                                    id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Daftar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('province_id').addEventListener('change', function() {
    const provinceId = this.value;
    const citySelect = document.getElementById('city_id');
    const villageSelect = document.getElementById('village_id');
    
    citySelect.innerHTML = '<option value="">Memuat...</option>';
    villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
    
    if (provinceId) {
        fetch(`/api/cities?province_id=${provinceId}`)
            .then(response => response.json())
            .then(cities => {
                citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                cities.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                });
            });
    } else {
        citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
    }
});

document.getElementById('city_id').addEventListener('change', function() {
    const cityId = this.value;
    const villageSelect = document.getElementById('village_id');
    
    villageSelect.innerHTML = '<option value="">Memuat...</option>';
    
    if (cityId) {
        fetch(`/api/villages?city_id=${cityId}`)
            .then(response => response.json())
            .then(villages => {
                villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                villages.forEach(village => {
                    villageSelect.innerHTML += `<option value="${village.id}">${village.name}</option>`;
                });
            });
    } else {
        villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
    }
});
</script>
@endpush
