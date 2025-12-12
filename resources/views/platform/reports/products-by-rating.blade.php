@extends('platform.reports.pdf-layout')

@section('title', 'Laporan Produk dan Rating')
@section('report-title', 'Daftar Produk dan Rating (Urut Rating Menurun)')

@section('report-meta')
    <p style="margin: 5px 0 0; color: #FFD700; font-size: 14px; font-weight: bold;">
        Laporan Produk dan Rating
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
            <th>Nama Toko</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Provinsi</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ Str::limit($product->nama_produk, 25) }}</td>
            <td>{{ $product->seller->nama_toko }}</td>
            <td>{{ $product->category->name }}</td>
            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
            <td>{{ $product->seller->province->name ?? '-' }}</td>
            <td>{{ number_format($product->rating_avg, 1) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total: {{ $products->count() }} produk</strong></p>
@endsection
