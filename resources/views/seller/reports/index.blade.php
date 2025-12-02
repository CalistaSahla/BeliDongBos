@extends('layouts.dashboard')

@section('title', 'Laporan PDF Penjual')

@section('content')
<h4 class="mb-4">Generate Laporan PDF</h4>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-box-seam"></i> Laporan Stok Produk</h5>
                <hr>
                <div class="d-grid gap-2">
                    <a href="{{ route('seller.report.products-by-stock') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> Daftar Stok Produk (Urut Stok Menurun) - SRS-12
                    </a>
                    <a href="{{ route('seller.report.products-by-rating') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-pdf"></i> Daftar Stok Produk (Urut Rating Menurun) - SRS-13
                    </a>
                    <a href="{{ route('seller.report.products-need-restock') }}" class="btn btn-outline-danger">
                        <i class="bi bi-file-pdf"></i> Produk Perlu Restock (Stok < 2) - SRS-14
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
