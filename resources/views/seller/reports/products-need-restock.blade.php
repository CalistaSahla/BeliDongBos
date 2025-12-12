@extends('seller.reports.pdf-layout')

@section('title', 'Laporan Produk Perlu Restock')
@section('report-title', 'Daftar Stok Barang Perlu Dipesan (Stok < 2) - SRS-14')

@section('report-meta')
    <p style="margin: 5px 0 0; color: #FFD700; font-size: 14px; font-weight: bold;">
        Laporan Produk Perlu Restock
    </p>
    <p style="margin: 5px 0 0; color: #FFD700; font-size: 10px; font-weight: bold;">
        Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh {{ Auth::user()->name ?? 'NamaAkun Default' }}
    </p>
@endsection

@section('content')
@if($products->count() > 0)
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Rating</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ Str::limit($product->nama_produk, 30) }}</td>
            <td>{{ $product->category->name }}</td>
            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
            <td class="text-center" style="background: #DC143C; color: white;">{{ $product->stok }}</td>
            <td class="text-center">{{ number_format($product->rating_avg, 1) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total: {{ $products->count() }} produk perlu di-restock</strong></p>
@else
<p style="text-align: center; padding: 20px; background: #32CD32; color: white; border: 2px solid #333;">
    <strong>Tidak ada produk yang perlu di-restock. Semua stok masih mencukupi!</strong>
</p>
@endif
@endsection
