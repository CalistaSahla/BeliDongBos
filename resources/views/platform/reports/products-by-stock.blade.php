@extends('platform.reports.pdf-layout')

@section('title', 'Laporan Stok Produk Tertinggi')
@section('report-title', 'Daftar Stok Produk Diurutkan Stok Tertinggi')

@section('content')
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Toko</th>
            <th>Provinsi</th>
            <th>Stok</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ Str::limit($product->nama_produk, 30) }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->seller->nama_toko }}</td>
            <td>{{ $product->seller->province->name ?? '-' }}</td>
            <td>{{ $product->stok }}</td>
            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total: {{ $products->count() }} produk</strong></p>
@endsection
