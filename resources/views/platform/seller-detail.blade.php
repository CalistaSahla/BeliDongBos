@extends('layouts.dashboard')

@section('title', 'Detail Penjual')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Detail Penjual</h4>
    <a href="{{ route('platform.pending-sellers') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white"><strong>Informasi Toko</strong></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td width="200" class="text-muted">Nama Toko</td><td><strong>{{ $seller->nama_toko }}</strong></td></tr>
                    <tr><td class="text-muted">Alamat</td><td>{{ $seller->alamat_toko }}</td></tr>
                    <tr><td class="text-muted">Kota/Kabupaten</td><td>{{ $seller->city->name ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Provinsi</td><td>{{ $seller->province->name ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Status</td><td>
                        @if($seller->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($seller->status == 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td></tr>
                    <tr><td class="text-muted">Tanggal Daftar</td><td>{{ $seller->created_at->format('d M Y H:i') }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white"><strong>Informasi PIC</strong></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td width="200" class="text-muted">Nama PIC</td><td>{{ $seller->nama_pic }}</td></tr>
                    <tr><td class="text-muted">Kontak PIC</td><td>{{ $seller->kontak_pic }}</td></tr>
                    <tr><td class="text-muted">Nomor HP</td><td>{{ $seller->nomor_hp }}</td></tr>
                    <tr><td class="text-muted">Email</td><td>{{ $seller->email }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white"><strong>Foto KTP PIC</strong></div>
            <div class="card-body text-center">
                @if($seller->foto_ktp)
                    <a href="{{ asset('storage/' . $seller->foto_ktp) }}" target="_blank">
                        <img src="{{ asset('storage/' . $seller->foto_ktp) }}" class="img-fluid rounded" style="max-height: 300px;">
                    </a>
                    <p class="text-muted mt-2"><small>Klik untuk memperbesar</small></p>
                @else
                    <p class="text-muted">Tidak ada foto KTP</p>
                @endif
            </div>
        </div>

        @if($seller->status == 'pending')
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Aksi Verifikasi</strong></div>
            <div class="card-body">
                <form action="{{ route('platform.seller.approve', $seller) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-success w-100" onclick="return confirm('Yakin ingin menyetujui penjual ini?')">
                        <i class="bi bi-check-circle"></i> Setujui Penjual
                    </button>
                </form>

                <hr>

                <form action="{{ route('platform.seller.reject', $seller) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="rejection_reason" class="form-control @error('rejection_reason') is-invalid @enderror" 
                            rows="3" placeholder="Masukkan alasan penolakan..." required></textarea>
                        @error('rejection_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menolak penjual ini?')">
                        <i class="bi bi-x-circle"></i> Tolak Penjual
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($seller->status == 'rejected' && $seller->rejection_reason)
        <div class="card shadow-sm border-danger">
            <div class="card-header bg-danger text-white"><strong>Alasan Penolakan</strong></div>
            <div class="card-body">
                {{ $seller->rejection_reason }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
