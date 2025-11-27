@extends('platform.reports.pdf-layout')

@section('title', 'Laporan Penjual per Provinsi')
@section('report-title', 'Daftar Penjual untuk Setiap Provinsi')

@section('content')
@foreach($provinces as $province)
<div class="section-title">{{ $province->name }} ({{ $province->sellers->count() }} penjual)</div>
@if($province->sellers->count() > 0)
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Toko</th>
            <th>Nama PIC</th>
            <th>Email</th>
            <th>Kota/Kabupaten</th>
        </tr>
    </thead>
    <tbody>
        @foreach($province->sellers as $index => $seller)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $seller->nama_toko }}</td>
            <td>{{ $seller->nama_pic }}</td>
            <td>{{ $seller->email }}</td>
            <td>{{ $seller->city->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>Tidak ada penjual di provinsi ini.</p>
@endif
@endforeach
@endsection
