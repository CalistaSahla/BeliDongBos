@extends('layouts.dashboard')

@section('title', 'Dashboard Platform')

@section('content')
<h4 class="mb-4">Dashboard Platform</h4>

<div class="row mb-4">
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Penjual</h6>
                <h3>{{ $stats['total_sellers'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Penjual Aktif</h6>
                <h3 class="text-success">{{ $stats['active_sellers'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Tidak Aktif</h6>
                <h3 class="text-secondary">{{ $stats['inactive_sellers'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Pending</h6>
                <h3 class="text-warning">{{ $stats['pending_sellers'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Produk</h6>
                <h3>{{ $stats['total_products'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Rating</h6>
                <h3>{{ $stats['total_ratings'] }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Sebaran Produk per Kategori</strong></div>
            <div class="card-body">
                <canvas id="categoryChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Sebaran Produk per Provinsi (Top 10)</strong></div>
            <div class="card-body">
                <canvas id="provinceChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Penjual Aktif vs Tidak Aktif</strong></div>
            <div class="card-body">
                <canvas id="sellerStatusChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Jumlah Pengunjung Memberi Rating</strong></div>
            <div class="card-body text-center py-5">
                <h1 class="display-4 text-primary">{{ number_format($ratingsCount) }}</h1>
                <p class="text-muted">pengunjung telah memberikan rating</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const categoryData = @json($productsPerCategory);
const provinceData = @json($productsPerProvince);

new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: categoryData.map(d => d.name),
        datasets: [{
            data: categoryData.map(d => d.count),
            backgroundColor: [
                '#663399', '#008080', '#FF6B35', '#FFD700', '#4169E1',
                '#32CD32', '#DC143C', '#FF69B4', '#00CED1', '#FF8C00',
                '#9370DB', '#20B2AA', '#FF7F50', '#ADFF2F', '#BA55D3'
            ],
            borderColor: '#333',
            borderWidth: 2
        }]
    },
    options: { responsive: true }
});

new Chart(document.getElementById('provinceChart'), {
    type: 'bar',
    data: {
        labels: provinceData.map(d => d.name),
        datasets: [{
            label: 'Jumlah Produk',
            data: provinceData.map(d => d.count),
            backgroundColor: ['#663399', '#008080', '#FF6B35', '#FFD700', '#4169E1', '#32CD32', '#DC143C', '#FF69B4', '#00CED1', '#FF8C00'],
            borderColor: '#333',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});

new Chart(document.getElementById('sellerStatusChart'), {
    type: 'pie',
    data: {
        labels: ['Aktif', 'Tidak Aktif'],
        datasets: [{
            data: [{{ $stats['active_sellers'] }}, {{ $stats['inactive_sellers'] }}],
            backgroundColor: ['#32CD32', '#808080'],
            borderColor: '#333',
            borderWidth: 3
        }]
    },
    options: { responsive: true }
});
</script>
@endpush
