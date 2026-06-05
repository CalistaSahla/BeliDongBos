@extends('platform.reports.pdf-layout')

@section('title', 'Laporan Penjual Aktif/Tidak Aktif')
@section('report-title', 'Laporan Penjual Aktif dan Tidak Aktif')

@section('content')
<div class="section-title">Penjual Aktif ({{ $activeSellers->count() }})</div>
@if($activeSellers->count() > 0)
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Toko</th>
            <th>Nama PIC</th>
            <th>Email</th>
            <th>Kota</th>
            <th>Provinsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activeSellers as $index => $seller)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $seller->nama_toko }}</td>
            <td>{{ $seller->nama_pic }}</td>
            <td>{{ $seller->email }}</td>
            <td>{{ $seller->city->name ?? '-' }}</td>
            <td>{{ $seller->province->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>Tidak ada penjual aktif.</p>
@endif

<div class="section-title">Penjual Tidak Aktif ({{ $inactiveSellers->count() }})</div>
@if($inactiveSellers->count() > 0)
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Toko</th>
            <th>Nama PIC</th>
            <th>Email</th>
            <th>Status</th>
            <th>Provinsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inactiveSellers as $index => $seller)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $seller->nama_toko }}</td>
            <td>{{ $seller->nama_pic }}</td>
            <td>{{ $seller->email }}</td>
            <td>{{ ucfirst($seller->status) }}</td>
            <td>{{ $seller->province->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>Tidak ada penjual tidak aktif.</p>
@endif
@endsection
