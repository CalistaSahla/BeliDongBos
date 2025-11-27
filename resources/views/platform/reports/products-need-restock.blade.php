@extends('platform.reports.pdf-layout')

@section('title', 'Laporan Produk Perlu Restock')
@section('report-title', 'Daftar Produk yang Harus Restock (Stok < 2)')

@section('content')
@if($products->count() > 0)
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
            <td style="color: red; font-weight: bold;">{{ $product->stok }}</td>
            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total: {{ $products->count() }} produk perlu restock</strong></p>
@else
<p>Tidak ada produk yang perlu restock. Semua produk memiliki stok >= 2.</p>
@endif
@endsection
