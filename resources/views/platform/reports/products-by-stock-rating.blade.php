@extends('platform.reports.pdf-layout')

@section('title', 'Laporan Stok Berdasarkan Rating')
@section('report-title', 'Daftar Stok Produk Diurutkan Berdasarkan Rating')

@section('report-meta')
    <p style="margin: 5px 0 0; color: #FFD700; font-size: 14px; font-weight: bold;">
        Laporan Stok Berdasarkan Rating
    </p>
    <p style="margin: 5px 0 0; color: #FFD700; font-size: 10px; font-weight: bold;">
        Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh {{ Auth::user()->name ?? 'NamaAkun Default' }}
    </p>
@endsection

@section('content')
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Toko</th>
            <th>Stok</th>
            <th>Rating</th>
            <th>Ulasan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ Str::limit($product->nama_produk, 30) }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->seller->nama_toko }}</td>
            <td>{{ $product->stok }}</td>
            <td>{{ number_format($product->rating_avg, 1) }}</td>
            <td>{{ $product->rating_count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total: {{ $products->count() }} produk</strong></p>
@endsection
