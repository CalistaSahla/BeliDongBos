@extends('layouts.dashboard')

@section('title', 'Laporan PDF Platform')

@section('content')
<h4 class="mb-4">Generate Laporan PDF Platform</h4>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Laporan Penjual (SRS-09, SRS-10)</h5>
                <hr>
                <div class="d-grid gap-2">
                    <a href="{{ route('report.sellers-active-inactive') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> Daftar Akun Penjual Aktif / Tidak Aktif
                    </a>
                    <a href="{{ route('report.sellers-by-province') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> Daftar Penjual (Toko) per Provinsi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-box-seam"></i> Laporan Produk (SRS-11)</h5>
                <hr>
                <div class="d-grid gap-2">
                    <a href="{{ route('report.products-by-rating') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> Daftar Produk & Rating (Urut Rating Menurun)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection