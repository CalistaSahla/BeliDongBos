<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BeliDongBos') - Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&family=Pixelify+Sans&display=swap');
        :root {
            --retro-purple: #663399;
            --retro-teal: #008080;
            --retro-orange: #FF6B35;
            --retro-yellow: #FFD700;
            --retro-blue: #4169E1;
            --retro-green: #32CD32;
            --retro-red: #DC143C;
        }
        html { height: 100%; }
        body { 
            background: linear-gradient(135deg, #FFFACD 0%, #E6E6FA 50%, #B0E0E6 100%);
            font-family: 'Comic Neue', cursive, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main { flex: 1; }
        .navbar { 
            background: linear-gradient(90deg, var(--retro-purple), var(--retro-teal)) !important;
            border-bottom: 4px solid var(--retro-yellow);
            box-shadow: 0 4px 0 #333;
        }
        .navbar-brand { 
            font-weight: bold; 
            color: var(--retro-yellow) !important; 
            text-shadow: 2px 2px 0 #333;
            font-size: 1.5rem;
        }
        .nav-link { color: #fff !important; font-weight: bold; }
        .nav-link:hover { color: var(--retro-yellow) !important; }
        .btn-primary { 
            background: linear-gradient(180deg, var(--retro-orange) 0%, #CC5500 100%);
            border: 3px solid #333;
            box-shadow: 3px 3px 0 #333;
            font-weight: bold;
            color: #fff;
        }
        .btn-primary:hover { 
            transform: translate(2px, 2px);
            box-shadow: 1px 1px 0 #333;
            background: linear-gradient(180deg, #FF8C00 0%, var(--retro-orange) 100%);
        }
        .btn-outline-primary { 
            color: var(--retro-purple); 
            border: 3px solid var(--retro-purple);
            background: #fff;
            font-weight: bold;
            box-shadow: 3px 3px 0 #333;
        }
        .btn-outline-primary:hover { 
            background: var(--retro-purple); 
            color: #fff;
            transform: translate(2px, 2px);
            box-shadow: 1px 1px 0 #333;
        }
        .text-primary { color: var(--retro-purple) !important; }
        .bg-primary { background: var(--retro-teal) !important; }
        a { color: var(--retro-blue); font-weight: 500; }
        a:hover { color: var(--retro-purple); }
        .product-card { 
            border: 3px solid #333 !important;
            box-shadow: 5px 5px 0 #333;
            background: #fff;
            transition: all 0.2s;
        }
        .product-card:hover { 
            transform: translate(-3px, -3px);
            box-shadow: 8px 8px 0 #333;
        }
        .product-image { height: 200px; object-fit: cover; border-bottom: 3px solid #333; }
        .rating-stars { color: var(--retro-yellow); text-shadow: 1px 1px 0 #333; }
        .footer { 
            background: linear-gradient(90deg, var(--retro-teal), var(--retro-purple));
            border-top: 4px solid var(--retro-yellow);
            color: #fff;
        }
        .footer a { color: var(--retro-yellow) !important; }
        .footer h5, .footer h6 { color: var(--retro-yellow); text-shadow: 1px 1px 0 #333; }
        .card { 
            border: 3px solid #333 !important;
            box-shadow: 4px 4px 0 #333;
            background: #fff;
        }
        .card-header { 
            background: linear-gradient(90deg, var(--retro-yellow), #FFA500) !important;
            border-bottom: 3px solid #333 !important;
            font-weight: bold;
            color: #333;
        }
        .pagination { gap: 3px; }
        .page-link { 
            color: #333;
            border: 2px solid #333;
            background: #fff;
            font-weight: bold;
            padding: 6px 12px;
            font-size: 13px;
        }
        .page-item.active .page-link { 
            background: var(--retro-purple);
            border-color: #333;
            color: #fff;
        }
        .page-item.disabled .page-link {
            background: #e9ecef;
            color: #6c757d;
        }
        .page-link:hover { background: var(--retro-yellow); color: #333; }
        .page-link svg { width: 12px; height: 12px; }
        .form-control, .form-select { 
            border: 2px solid #333;
            border-radius: 0;
        }
        .form-control:focus, .form-select:focus { 
            border-color: var(--retro-purple);
            box-shadow: 3px 3px 0 var(--retro-purple);
        }
        h1, h2, h3, h4, h5, h6 { font-family: 'Pixelify Sans', 'Comic Neue', sans-serif; }
        .badge { 
            border: 2px solid #333;
            font-weight: bold;
        }
        .badge.bg-success { background: var(--retro-green) !important; }
        .badge.bg-danger { background: var(--retro-red) !important; }
        .badge.bg-warning { background: var(--retro-yellow) !important; color: #333 !important; }
        .alert { border: 3px solid #333; border-radius: 0; box-shadow: 4px 4px 0 #333; }
        .alert-success { background: #90EE90; }
        .alert-danger { background: #FFB6C1; }
        ::selection { background: var(--retro-yellow); color: #333; }
        .table { border: 2px solid #333; }
        .table th { background: var(--retro-teal); color: #fff; border: 2px solid #333; }
        .table td { border: 2px solid #333; }
        .btn-sm { padding: 4px 10px; font-size: 13px; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('catalog.index') }}">
                <i class="bi bi-shop"></i> BeliDongBos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex mx-auto" style="width: 50%;" action="{{ route('catalog.index') }}" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari produk, toko, atau kategori..." value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                </form>
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(auth()->user()->isPlatform())
                            <li class="nav-item"><a class="nav-link" href="{{ route('platform.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                        @elseif(auth()->user()->isSeller())
                            <li class="nav-item"><a class="nav-link" href="{{ route('seller.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                        @endif
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="bi bi-person"></i> Login</a></li>
                        <li class="nav-item"><a class="btn btn-primary btn-sm ms-2" href="{{ route('seller.register') }}">Daftar Jadi Penjual</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="footer mt-auto py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="bi bi-shop"></i> BeliDongBos</h5>
                    <p class="text-muted">Marketplace terpercaya untuk semua kebutuhan Anda.</p>
                </div>
                <div class="col-md-4">
                    <h6>Link Cepat</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('catalog.index') }}" class="text-decoration-none text-muted">Katalog Produk</a></li>
                        <li><a href="{{ route('seller.register') }}" class="text-decoration-none text-muted">Daftar Jadi Penjual</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Kontak</h6>
                    <p class="text-muted mb-0"><i class="bi bi-envelope"></i> info@belidongbos.com</p>
                    <p class="text-muted"><i class="bi bi-telephone"></i> (021) 1234567</p>
                </div>
            </div>
            <hr>
            <p class="text-center text-muted mb-0">&copy; {{ date('Y') }} BeliDongBos. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
