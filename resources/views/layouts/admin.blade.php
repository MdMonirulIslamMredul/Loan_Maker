<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: #ffffff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #495057;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu .menu-item:hover {
            background: #f8f9fa;
            color: #0d6efd;
            border-left-color: #0d6efd;
        }

        .sidebar-menu .menu-item.active {
            background: #e7f1ff;
            color: #0d6efd;
            border-left-color: #0d6efd;
            font-weight: 600;
        }

        .sidebar-menu .menu-item i {
            width: 24px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .menu-section-title {
            padding: 1rem 1.5rem 0.5rem;
            color: #6c757d;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        .top-navbar {
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .sidebar-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: inline-block;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-light">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5 class="mb-0"><i class="bi bi-shield-check me-2"></i>Admin Panel</h5>
            <small class="opacity-75">{{ auth()->user()->name }}</small>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section-title">Main</div>
            <a href="{{ route('super-admin.dashboard') }}" class="menu-item {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <div class="menu-section-title">Banks Management</div>
            <a href="{{ route('super-admin.banks.create') }}" class="menu-item {{ request()->routeIs('super-admin.banks.create') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Create Bank</span>
            </a>
            <a href="{{ route('super-admin.banks.index') }}" class="menu-item {{ request()->routeIs('super-admin.banks.index') ? 'active' : '' }}">
                <i class="bi bi-bank"></i>
                <span>View All Banks</span>
            </a>
            <a href="{{ route('super-admin.bank-admins.create') }}" class="menu-item {{ request()->routeIs('super-admin.bank-admins.create') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i>
                <span>Create Bank Admin</span>
            </a>
            <a href="{{ route('super-admin.bank-admins.index') }}" class="menu-item {{ request()->routeIs('super-admin.bank-admins.index') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>View Bank Admins</span>
            </a>

            <div class="menu-section-title">Branches Management</div>
            <a href="{{ route('super-admin.branches.create') }}" class="menu-item {{ request()->routeIs('super-admin.branches.create') ? 'active' : '' }}">
                <i class="bi bi-shop"></i>
                <span>Create Branch</span>
            </a>
            <a href="{{ route('super-admin.branches.index') }}" class="menu-item {{ request()->routeIs('super-admin.branches.index') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i>
                <span>View All Branches</span>
            </a>
            <a href="{{ route('super-admin.branch-admins.create') }}" class="menu-item {{ request()->routeIs('super-admin.branch-admins.create') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i>
                <span>Create Branch Admin</span>
            </a>
            <a href="{{ route('super-admin.branch-admins.index') }}" class="menu-item {{ request()->routeIs('super-admin.branch-admins.index') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>View Branch Admins</span>
            </a>

            <div class="menu-section-title">Loans Management</div>
            <a href="{{ route('super-admin.loans.create') }}" class="menu-item {{ request()->routeIs('super-admin.loans.create') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i>
                <span>Create Loan</span>
            </a>
            <a href="{{ route('super-admin.loans.index') }}" class="menu-item {{ request()->routeIs('super-admin.loans.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i>
                <span>View All Loans</span>
            </a>

            <div class="menu-section-title">Applications</div>
            <a href="{{ route('super-admin.applications.index') }}" class="menu-item {{ request()->routeIs('super-admin.applications.index') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i>
                <span>Loan Applications</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar top-navbar">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link sidebar-toggle me-3" id="sidebarToggle">
                        <i class="bi bi-list fs-4 text-dark"></i>
                    </button>
                    <h5 class="mb-0">@yield('dashboard-title', 'Dashboard')</h5>
                </div>
                <div class="d-flex align-items-center">
                    <span class="text-dark me-3 d-none d-md-inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid py-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                !toggle.contains(event.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
