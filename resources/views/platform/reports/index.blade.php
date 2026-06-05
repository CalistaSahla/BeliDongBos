@extends('layouts.dashboard')

@section('title', 'Laporan PDF')

@section('content')
<h4 class="mb-4">Generate Laporan PDF</h4>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Laporan Penjual</h5>
                <hr>
                <div class="d-grid gap-2">
                    <a href="{{ route('report.sellers-active-inactive') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> Penjual Aktif / Tidak Aktif
                    </a>
                    <a href="{{ route('report.sellers-by-province') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> Penjual per Provinsi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-box-seam"></i> Laporan Produk</h5>
                <hr>
                <div class="d-grid gap-2">
                    <a href="{{ route('report.products-by-rating') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> Produk Berdasarkan Rating Tertinggi
                    </a>
                    <a href="{{ route('report.products-by-stock') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> Stok Produk Tertinggi
                    </a>
                    <a href="{{ route('report.products-by-stock-rating') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> Stok Produk Berdasarkan Rating
                    </a>
                    <a href="{{ route('report.products-need-restock') }}" class="btn btn-outline-danger">
                        <i class="bi bi-file-pdf"></i> Produk Perlu Restock (Stok < 2)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
