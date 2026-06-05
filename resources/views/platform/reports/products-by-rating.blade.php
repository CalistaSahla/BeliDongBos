@extends('platform.reports.pdf-layout')

@section('title', 'Laporan Produk Rating Tertinggi')
@section('report-title', 'Daftar Produk Diurutkan Rating Tertinggi')

@section('content')
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Toko</th>
            <th>Provinsi</th>
            <th>Rating</th>
            <th>Jumlah Ulasan</th>
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
            <td>{{ number_format($product->rating_avg, 1) }}</td>
            <td>{{ $product->rating_count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total: {{ $products->count() }} produk</strong></p>
@endsection
