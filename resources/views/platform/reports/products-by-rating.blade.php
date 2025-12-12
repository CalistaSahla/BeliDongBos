@extends('platform.reports.pdf-layout')

@section('title', 'Laporan Daftar Produk Berdasarkan Rating')
@section('report-title', 'Daftar Produk Berdasarkan Rating')

@section('report-meta')
    <p style="margin: 5px 0 0; color: #FFD700; font-size: 14px; font-weight: bold;">
        Laporan Daftar Produk Berdasarkan Rating (Menurun)
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
            <th>Produk</th>         {{-- POSISI 2 --}}
            <th>Kategori</th>       {{-- POSISI 3 --}}
            <th>Harga</th>          {{-- POSISI 4 --}}
            <th>Rating</th>         {{-- POSISI 5 --}}
            <th>Nama Toko</th>      {{-- POSISI 6 --}}
            <th>Provinsi</th>       {{-- POSISI 7 --}}
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ Str::limit($product->nama_produk, 30) }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ number_format($product->harga ?? 0) }}</td> 
            <td>{{ number_format($product->rating_avg, 1) }}</td>
            <td>{{ $product->seller->nama_toko }}</td>
            <td>{{ $product->seller->province->name ?? '-' }}</td> 
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total: {{ $products->count() }} produk</strong></p>
@endsection
