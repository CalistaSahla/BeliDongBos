@extends('seller.reports.pdf-layout')

@section('title', 'Laporan Stok Produk Berdasarkan Rating')
@section('report-title', 'Daftar Stok Produk (Urut Rating Menurun) - SRS-13')

@section('content')
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
            <td class="text-center">{{ $product->stok }}</td>
            <td class="text-center">{{ number_format($product->rating_avg, 1) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total: {{ $products->count() }} produk</strong></p>
@endsection
