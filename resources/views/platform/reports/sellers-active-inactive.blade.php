@extends('platform.reports.pdf-layout')

@section('title', 'Laporan Penjual Berdasarkan Status')

@section('report-meta')
    <p style="margin: 5px 0 0; color: #FFD700; font-size: 14px; font-weight: bold;">
        Laporan Penjual Berdasarkan Status
    </p>
    <p style="margin: 5px 0 0; color: #FFD700; font-size: 10px; font-weight: bold;">
        Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh {{ Auth::user()->name ?? 'NamaAkun Default' }}
    </p>
@endsection

@section('content')

@php
    $totalSellers = $activeSellers->count() + $inactiveSellers->count();
@endphp

@if($totalSellers > 0)
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Nama PIC</th>
            <th>Nama Toko</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach($activeSellers as $index => $seller)
        <tr>
            <td>{{ $index + 1 }}</td>
            {{-- Asumsi 'Nama User' adalah 'Email' atau 'Nama PIC' --}}
            <td>{{ $seller->email }}</td> 
            <td>{{ $seller->nama_pic }}</td>
            <td>{{ $seller->nama_toko }}</td>
            <td>Aktif</td> {{-- Tetapkan status 'Aktif' --}}
        </tr>
        @endforeach

        @php
            $startIndex = $activeSellers->count();
        @endphp
        
        @foreach($inactiveSellers as $index => $seller)
        <tr>
            <td>{{ $startIndex + $index + 1 }}</td>
            {{-- Asumsi 'Nama User' adalah 'Email' atau 'Nama PIC' --}}
            <td>{{ $seller->email }}</td>
            <td>{{ $seller->nama_pic }}</td>
            <td>{{ $seller->nama_toko }}</td>
            <td>{{ ucfirst($seller->status) }}</td>
        </tr>
        @endforeach

    </tbody>
</table>

@else
<p>Tidak ada data penjual yang tersedia.</p>
@endif

@endsection