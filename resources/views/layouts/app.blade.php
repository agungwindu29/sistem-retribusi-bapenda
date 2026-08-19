<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Realisasi Retribusi Mobile & Web') - BAPENDA</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --primary-red: #dc2626;
            --dark-red: #991b1b;
            --deep-burgundy: #7f1d1d;
            --light-red-bg: #fef2f2;
            --border-color: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* Sidebar Styling Desktop */
        .sidebar-desktop {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #7f1d1d 0%, #991b1b 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
            color: white;
            transition: all 0.3s ease;
        }

        .brand-box {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .brand-logo-icon {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .nav-section-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.55);
            padding: 18px 24px 8px;
            font-weight: 700;
        }

        .sidebar-desktop .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 600;
            padding: 12px 20px;
            margin: 4px 14px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .sidebar-desktop .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transform: translateX(3px);
        }

        .sidebar-desktop .nav-link.active {
            background: #ffffff;
            color: var(--dark-red);
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Card Styling */
        .card-custom {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            transition: all 0.25s ease;
        }

        .card-custom:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .badge-red {
            background-color: var(--light-red-bg);
            color: var(--dark-red);
            font-weight: 700;
            border: 1px solid rgba(153, 27, 27, 0.2);
        }

        .btn-red {
            background-color: var(--dark-red);
            color: #ffffff;
            font-weight: 600;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-red:hover {
            background-color: var(--deep-burgundy);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(153, 27, 27, 0.3);
        }

        /* Header Mobile */
        .mobile-header {
            display: none;
            background: linear-gradient(90deg, #7f1d1d 0%, #991b1b 100%);
            color: white;
            padding: 14px 20px;
            position: sticky;
            top: 0;
            z-index: 1050;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 991.98px) {
            .sidebar-desktop { display: none; }
            .main-wrapper { margin-left: 0; padding: 16px; }
            .mobile-header { display: flex; align-items: center; justify-content: space-between; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- MOBILE HEADER -->
    <header class="mobile-header">
        <div class="d-flex align-items-center gap-2">
            <div class="brand-logo-icon" style="width: 36px; height: 36px; font-size: 18px;">
                <i class="fas fa-file-invoice-dollar text-white"></i>
            </div>
            <div>
                <h6 class="fw-bold m-0 text-white" style="line-height: 1.2;">Sistem Retribusi</h6>
                <small class="text-white-50" style="font-size: 0.72rem;">BAPENDA Realisasi</small>
            </div>
        </div>
        <button class="btn btn-outline-light rounded-circle p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
            <i class="fas fa-bars fa-lg"></i>
        </button>
    </header>

    <!-- MOBILE OFFCANVAS SIDEBAR -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" style="background: linear-gradient(180deg, #7f1d1d 0%, #991b1b 100%) !important;">
        <div class="offcanvas-header border-bottom border-light border-opacity-10">
            <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center gap-2">
                <i class="fas fa-file-invoice-dollar"></i> RetribusiWeb
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 pt-3">
            <div class="nav-section-title">Menu utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link text-white p-3 d-flex align-items-center gap-3 {{ request()->routeIs('dashboard') ? 'bg-white text-danger fw-bold' : '' }}">
                <i class="fas fa-chart-pie me-2"></i> Dashboard Overview
            </a>
            <a href="{{ route('upload.index') }}" class="nav-link text-white p-3 d-flex align-items-center gap-3 {{ request()->routeIs('upload.*') ? 'bg-white text-danger fw-bold' : '' }}">
                <i class="fas fa-file-upload me-2"></i> Upload PDF & Parsing
            </a>
            <a href="{{ route('realisasi.index') }}" class="nav-link text-white p-3 d-flex align-items-center gap-3 {{ request()->routeIs('realisasi.*') ? 'bg-white text-danger fw-bold' : '' }}">
                <i class="fas fa-table me-2"></i> Data Realisasi
            </a>
            @if(Auth::check() && Auth::user()->isAdmin())
            <a href="{{ route('audit.index') }}" class="nav-link text-white p-3 d-flex align-items-center gap-3 {{ request()->routeIs('audit.*') ? 'bg-white text-danger fw-bold' : '' }}">
                <i class="fas fa-history me-2"></i> Audit Trail Log
            </a>
            @endif
            <hr class="border-light border-opacity-25 mx-3">
            <form action="{{ route('logout') }}" method="POST" class="px-3">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100 text-start">
                    <i class="fas fa-sign-out-alt me-2"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- DESKTOP SIDEBAR -->
    <aside class="sidebar-desktop">
        <div class="brand-box d-flex align-items-center gap-3">
            <div class="brand-logo-icon">
                <i class="fas fa-building-columns"></i>
            </div>
            <div>
                <h6 class="fw-bold m-0 text-white" style="letter-spacing: 0.02em;">SITRIBU RED</h6>
                <small class="text-white-50" style="font-size: 0.72rem;">Realisasi Retribusi OPD</small>
            </div>
        </div>

        <div class="nav-section-title">Navigasi Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Overview
        </a>
        <a href="{{ route('upload.index') }}" class="nav-link {{ request()->routeIs('upload.*') ? 'active' : '' }}">
            <i class="fas fa-file-upload"></i> Upload PDF & Parsing
        </a>
        <a href="{{ route('realisasi.index') }}" class="nav-link {{ request()->routeIs('realisasi.*') ? 'active' : '' }}">
            <i class="fas fa-table"></i> Data Realisasi
        </a>

        @if(Auth::check() && Auth::user()->isAdmin())
        <a href="{{ route('audit.index') }}" class="nav-link {{ request()->routeIs('audit.*') ? 'active' : '' }}">
            <i class="fas fa-history"></i> Audit Log
        </a>
        @endif

        <div class="position-absolute bottom-0 start-0 w-100 p-3" style="border-top: 1px solid rgba(255,255,255,0.12);">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-white rounded-circle text-danger d-flex align-items-center justify-content-center fw-bold" style="width:32px; height:32px; font-size:14px;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div style="line-height:1.2; overflow:hidden;">
                        <span class="d-block text-white text-truncate small fw-bold">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                        <small class="text-white-50" style="font-size:0.7rem;">{{ Auth::user()->opd_name ?? 'OPD' }}</small>
                    </div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light w-100 mt-1">
                    <i class="fas fa-sign-out-alt me-1"></i> Log Out
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-wrapper">

        <!-- TOP BAR / OFFICIAL USER BADGE -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between pb-3 mb-4 border-bottom">
            <div>
                <h4 class="fw-bold mb-1" style="color: var(--dark-red);">@yield('page_heading', 'Dashboard Overview')</h4>
                <p class="text-muted small mb-0">Sistem Informasi Pengelolaan & Validasi Realisasi Retribusi Daerah</p>
            </div>

            <!-- Official Logged In Status (No backdoor role switching) -->
            <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fw-bold">
                    <i class="fas fa-shield-halved me-1"></i> Mode Akses: {{ Auth::user()->isAdmin() ? 'ADMINISTRATOR BAPENDA' : 'OPERATOR ' . strtoupper(Auth::user()->opd_name) }}
                </span>
            </div>
        </div>

        <!-- ALERTS -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
