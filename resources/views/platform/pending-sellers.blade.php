@extends('layouts.dashboard')

@section('title', 'Verifikasi Penjual')

@section('content')
<h4 class="mb-4">Penjual Menunggu Verifikasi</h4>

<div class="card shadow-sm">
    <div class="card-body">
        @if($sellers->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Toko</th>
                        <th>Nama PIC</th>
                        <th>Email</th>
                        <th>Lokasi</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sellers as $seller)
                    <tr>
                        <td>{{ $seller->nama_toko }}</td>
                        <td>{{ $seller->nama_pic }}</td>
                        <td>{{ $seller->email }}</td>
                        <td>{{ $seller->city->name ?? '' }}, {{ $seller->province->name ?? '' }}</td>
                        <td>{{ $seller->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('platform.seller.show', $seller) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $sellers->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
            <p class="text-muted mt-3">Tidak ada penjual yang menunggu verifikasi.</p>
        </div>
        @endif
    </div>
</div>
@endsection
