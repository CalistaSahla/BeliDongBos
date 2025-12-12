<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title') - BeliDongBos</title>
    <style>
        body { font-family: 'Comic Sans MS', Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 4px solid #FFD700; padding-bottom: 10px; background: linear-gradient(90deg, #663399, #008080); color: white; padding: 15px; }
        .header h1 { color: #FFD700; margin: 0; font-size: 16px; text-shadow: 2px 2px 0 #333; }        .header p { margin: 5px 0 0; color: #fff; font-size: 10px; }
        .header p { margin: 5px 0 0; color: #fff; font-size: 10px; }
        .seller-info { background: #FFFACD; padding: 10px; margin-bottom: 15px; border: 2px solid #333; }
        .seller-info h3 { margin: 0 0 5px; color: #663399; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; border: 3px solid #333; }
        th, td { border: 2px solid #333; padding: 8px; text-align: left; }
        th { background-color: #008080; color: white; }
        tr:nth-child(even) { background-color: #FFFACD; }
        tr:nth-child(odd) { background-color: #E6E6FA; }
        .section-title { background: linear-gradient(90deg, #FFD700, #FFA500); padding: 10px; margin: 15px 0 5px; font-weight: bold; color: #333; border: 2px solid #333; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #663399; font-weight: bold; }
        .badge { padding: 2px 8px; border-radius: 0; font-size: 10px; border: 2px solid #333; }
        .badge-success { background: #32CD32; color: white; }
        .badge-danger { background: #DC143C; color: white; }
        .badge-warning { background: #FFD700; color: #333; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
    <h1>BeliDongBos Marketplace</h1>
    @yield('report-meta') 
    </div>

    <div class="seller-info">
        <h3>Toko: {{ $seller->nama_toko }}</h3>
        <p>Pemilik: {{ $seller->nama_pic }} | Lokasi: {{ $seller->city->name ?? '-' }}, {{ $seller->province->name ?? '-' }}</p>
    </div>

    @yield('content')

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh sistem BeliDongBos</p>
    </div>
</body>
</html>
