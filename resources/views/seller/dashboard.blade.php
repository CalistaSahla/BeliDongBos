@extends('layouts.dashboard')

@section('title', 'Dashboard Penjual')

@section('content')
<h4 class="mb-4">Dashboard Penjual</h4>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Produk</h6>
                <h3>{{ $stats['total_products'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Stok</h6>
                <h3>{{ $stats['total_stock'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Perlu Restock</h6>
                <h3 class="text-danger">{{ $stats['low_stock'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Rating Rata-rata</h6>
                <h3><i class="bi bi-star-fill text-warning"></i> {{ number_format($stats['avg_rating'], 1) }}</h3>
                <small class="text-muted">dari {{ $stats['total_ratings'] }} ulasan</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Sebaran Stok Produk</strong></div>
            <div class="card-body">
                <canvas id="stockChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Rating per Produk</strong></div>
            <div class="card-body">
                <canvas id="ratingChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Rating Berdasarkan Provinsi Pemberi Rating</strong></div>
            <div class="card-body">
                <canvas id="ratingProvinceChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const stockData = @json($stockDistribution);
const ratingData = @json($ratingPerProduct);
const provinceData = @json($ratingByProvince);

const retroColors = ['#663399', '#008080', '#FF6B35', '#FFD700', '#4169E1', '#32CD32', '#DC143C', '#FF69B4', '#00CED1', '#FF8C00'];

new Chart(document.getElementById('stockChart'), {
    type: 'bar',
    data: {
        labels: stockData.map(d => d.name.substring(0, 20)),
        datasets: [{
            label: 'Stok',
            data: stockData.map(d => d.stock),
            backgroundColor: retroColors
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});

new Chart(document.getElementById('ratingChart'), {
    type: 'bar',
    data: {
        labels: ratingData.map(d => d.name.substring(0, 20)),
        datasets: [{
            label: 'Rating',
            data: ratingData.map(d => d.rating),
            backgroundColor: '#FFD700',
            borderColor: '#333',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { max: 5 } }
    }
});

new Chart(document.getElementById('ratingProvinceChart'), {
    type: 'bar',
    data: {
        labels: provinceData.map(d => d.province),
        datasets: [
            {
                label: 'Jumlah Ulasan',
                data: provinceData.map(d => d.count),
                backgroundColor: '#008080'
            },
            {
                label: 'Rating Rata-rata',
                data: provinceData.map(d => d.avg),
                backgroundColor: '#FF6B35'
            }
        ]
    },
    options: {
        responsive: true
    }
});
</script>
@endpush
