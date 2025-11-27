@extends('layouts.dashboard')

@section('title', 'Semua Penjual')

@section('content')
<h4 class="mb-4">Semua Penjual</h4>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('platform.all-sellers') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="province_id" class="form-select">
                    <option value="">Semua Provinsi</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

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
                        <th>Produk</th>
                        <th>Status</th>
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
                        <td>{{ $seller->products_count }}</td>
                        <td>
                            @if($seller->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($seller->status == 'approved')
                                @if($seller->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('platform.seller.show', $seller) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
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
            <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
            <p class="text-muted mt-3">Tidak ada penjual ditemukan.</p>
        </div>
        @endif
    </div>
</div>
@endsection
