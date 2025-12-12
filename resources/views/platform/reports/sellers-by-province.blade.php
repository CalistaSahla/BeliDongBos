@extends('platform.reports.pdf-layout')

@section('title', 'Laporan Penjual per Provinsi')
@section('report-title', 'Daftar Penjual untuk Setiap Provinsi')

@section('report-meta')
    <p style="margin: 5px 0 0; color: #FFD700; font-size: 14px; font-weight: bold;">
        Laporan Penjual per Provinsi
    </p>
    <p style="margin: 5px 0 0; color: #FFD700; font-size: 10px; font-weight: bold;">
        Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh {{ Auth::user()->name ?? 'NamaAkun Default' }}
    </p>
@endsection

@section('content')

@php
    $counter = 0;
    
    $totalSellers = 0;
    foreach ($provinces as $province) {
        $totalSellers += $province->sellers->count();
    }
@endphp

@if($totalSellers > 0)
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Toko</th>
            <th>Nama PIC</th>
            <th>Provinsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($provinces as $province)
            @foreach($province->sellers as $seller)
            @php
                $counter++;
            @endphp
            <tr>
                <td>{{ $counter }}</td>
                <td>{{ $seller->nama_toko }}</td>
                <td>{{ $seller->nama_pic }}</td>
                <td>{{ $province->name }}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

@else
    <p>Tidak ada penjual yang terdaftar di semua provinsi.</p>
@endif

@endsection