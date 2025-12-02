<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - BeliDongBos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&family=Pixelify+Sans&display=swap');
        :root { 
            --retro-purple: #663399;
            --retro-teal: #008080;
            --retro-orange: #FF6B35;
            --retro-yellow: #FFD700;
            --retro-blue: #4169E1;
            --retro-green: #32CD32;
        }
        body { font-family: 'Comic Neue', cursive, Arial, sans-serif; }
        .sidebar { 
            min-height: 100vh; 
            background: linear-gradient(180deg, #2C2C54 0%, #474787 100%);
            border-right: 4px solid var(--retro-yellow);
        }
        .sidebar .nav-link { 
            color: rgba(255,255,255,.9); 
            padding: 0.75rem 1rem; 
            border-left: 4px solid transparent;
            font-weight: bold;
        }
        .sidebar .nav-link:hover { 
            color: var(--retro-yellow); 
            background: rgba(255,255,255,.1);
            border-left-color: var(--retro-yellow);
        }
        .sidebar .nav-link.active { 
            color: #333; 
            background: var(--retro-yellow);
            border-left-color: var(--retro-orange);
        }
        .sidebar .nav-link i { margin-right: 0.5rem; }
        .main-content { 
            background: linear-gradient(135deg, #FFFACD 0%, #E6E6FA 50%, #B0E0E6 100%);
            min-height: 100vh; 
        }
        .stat-card { 
            border: 3px solid #333 !important;
            border-left: 6px solid var(--retro-orange) !important;
            box-shadow: 4px 4px 0 #333;
        }
        .btn-primary { 
            background: linear-gradient(180deg, var(--retro-orange) 0%, #CC5500 100%);
            border: 3px solid #333;
            box-shadow: 3px 3px 0 #333;
            font-weight: bold;
        }
        .btn-primary:hover { transform: translate(2px, 2px); box-shadow: 1px 1px 0 #333; }
        .btn-outline-primary { 
            color: var(--retro-purple); 
            border: 3px solid var(--retro-purple);
            font-weight: bold;
            box-shadow: 3px 3px 0 #333;
        }
        .btn-outline-primary:hover { background: var(--retro-purple); color: #fff; }
        .card { border: 3px solid #333 !important; box-shadow: 4px 4px 0 #333; background: #fff; }
        .card-header { 
            background: linear-gradient(90deg, var(--retro-yellow), #FFA500) !important;
            border-bottom: 3px solid #333 !important;
            font-weight: bold;
        }
        a { color: var(--retro-blue); }
        h1, h2, h3, h4, h5, h6 { font-family: 'Pixelify Sans', 'Comic Neue', sans-serif; }
        .table { border: 2px solid #333; }
        .table th { background: var(--retro-teal); color: #fff; border: 2px solid #333; }
        .table td { border: 2px solid #333; }
        .badge { border: 2px solid #333; font-weight: bold; }
        .form-control, .form-select { border: 2px solid #333; border-radius: 0; }
        .pagination { gap: 3px; }
        .page-link { border: 2px solid #333; font-weight: bold; padding: 6px 12px; font-size: 13px; background: #fff; color: #333; }
        .page-item.active .page-link { background: var(--retro-purple); border-color: #333; color: #fff; }
        .page-item.disabled .page-link { background: #e9ecef; color: #6c757d; }
        .page-link:hover { background: var(--retro-yellow); color: #333; }
        .alert { border: 3px solid #333; border-radius: 0; box-shadow: 4px 4px 0 #333; }
        .btn-sm { padding: 4px 10px; font-size: 13px; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar py-3">
                <div class="text-center mb-4">
                    <a href="{{ route('catalog.index') }}" class="text-decoration-none text-white">
                        <h5><i class="bi bi-shop"></i> BeliDongBos</h5>
                    </a>
                </div>
                <ul class="nav flex-column">
                    @if(auth()->user()->isPlatform())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('platform.dashboard') ? 'active' : '' }}" href="{{ route('platform.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('platform.pending-sellers') ? 'active' : '' }}" href="{{ route('platform.pending-sellers') }}">
                                <i class="bi bi-hourglass-split"></i> Verifikasi Penjual
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('platform.all-sellers') ? 'active' : '' }}" href="{{ route('platform.all-sellers') }}">
                                <i class="bi bi-people"></i> Semua Penjual
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('platform.reports') ? 'active' : '' }}" href="{{ route('platform.reports') }}">
                                <i class="bi bi-file-earmark-pdf"></i> Laporan PDF
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}" href="{{ route('seller.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }}" href="{{ route('seller.products.index') }}">
                                <i class="bi bi-box-seam"></i> Produk Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seller.reports') ? 'active' : '' }}" href="{{ route('seller.reports') }}">
                                <i class="bi bi-file-earmark-pdf"></i> Laporan PDF
                            </a>
                        </li>
                    @endif
                    <hr class="text-white">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalog.index') }}">
                            <i class="bi bi-house"></i> Ke Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-start w-100">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

            <main class="col-md-10 ms-sm-auto main-content py-4 px-4">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
