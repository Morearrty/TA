<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - TA-AMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #faf7ff;
            transition: all 0.3s;
        }
        
        /* Sidebar dengan nuansa ungu - dengan gradient yang lebih menarik */
        .sidebar {
            background: linear-gradient(180deg, var(--color-purple-950) 0%, var(--color-purple-900) 100%);
            color: #fff;
            min-height: 100vh;
            position: fixed;
            width: 250px;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .sidebar.collapsed {
            width: 60px;
            overflow-x: hidden;
        }
        
        .menu-item span {
            transition: all 0.3s ease;
            opacity: 1;
            white-space: nowrap;
        }
        
        .sidebar.collapsed .menu-item span {
            display: none;
            opacity: 0;
            width: 0;
        }
        
        .sidebar.collapsed .menu-item {
            padding: 12px;
            text-align: center;
            width: 100%;
        }
        
        .main-content {
            margin-left: 250px;
            transition: all 0.3s ease;
            padding: 20px;
            min-height: 100vh;
            width: auto;
        }
        
        .main-content.expanded {
            margin-left: 60px;
        }
        
        .menu-item {
            padding: 12px 15px;
            display: flex;
            align-items: center;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px 10px;
            transition: all 0.2s ease;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        
        .menu-icon {
            margin-right: 12px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
        }
        
        .sidebar.collapsed .menu-icon {
            margin-right: 0;
        }
        
        /* Header dengan nuansa ungu */
        .admin-header {
            background-color: #fff;
            padding: 15px 20px;
            border-bottom: 1px solid #eaeaea;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
            height: 70px;
        }
        
        .toggle-menu {
            background: none;
            border: none;
            color: var(--color-purple-700);
            font-size: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 0;
            margin-right: 15px;
        }
        
        .page-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--color-purple-900);
            margin: 0;
            padding: 0;
        }
        
        .profile-dropdown {
            position: relative;
        }
        
        .profile-btn {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }
        
        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--color-purple-100);
            color: var(--color-purple-900);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
        }
        
        .profile-name {
            font-weight: 600;
            color: var(--color-purple-900);
            margin-right: 5px;
        }
        
        .dropdown-content {
            position: absolute;
            right: 0;
            top: 45px;
            background-color: #fff;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 5px 0;
            z-index: 1000;
            display: none;
        }
        
        .dropdown-content.show {
            display: block;
        }
        
        .dropdown-item {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            color: #333;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: var(--color-purple-50);
        }
        
        .dropdown-icon {
            margin-right: 10px;
            color: var(--color-purple-700);
        }
        
        /* Specific colors for button variations */
        .btn-purple {
            background-color: var(--color-purple-600);
            color: white;
            border: none;
        }
        
        .btn-purple:hover {
            background-color: var(--color-purple-700);
            color: white;
        }
        
        .btn-yellow {
            background-color: var(--color-yellow-400);
            color: var(--color-purple-900);
            border: none;
            font-weight: 500;
        }
        
        .btn-yellow:hover {
            background-color: var(--color-yellow-500);
            color: var(--color-purple-900);
        }
        
        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Utility classes */
        .text-purple {
            color: var(--color-purple-600) !important;
        }
        
        .text-yellow {
            color: var(--color-yellow-500) !important;
        }
        
        .bg-purple-light {
            background-color: var(--color-purple-50) !important;
        }
        
        .border-purple {
            border-color: var(--color-purple-200) !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 60px;
            }
            
            .sidebar .menu-item span {
                display: none;
            }
            
            .sidebar .menu-item {
                padding: 12px;
                text-align: center;
            }
            
            .sidebar .menu-icon {
                margin-right: 0;
            }
            
            .main-content {
                margin-left: 60px;
            }
        }
        
        @media (max-width: 576px) {
            .admin-header {
                padding: 10px;
            }
            
            .profile-name {
                display: none;
            }
        }
        
        @media (max-width: 991.98px) {
            .sidebar {
                width: 60px;
            }
            .main-content, .main-content.expanded {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 10px;
            }
        }
        
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                z-index: 1050;
                width: 200px;
            }
            .main-content, .main-content.expanded {
                margin-left: 0 !important;
                width: 100%;
                padding: 10px;
            }
        }
        
        /* Define CSS variables for consistent color scheme */
        :root {
            --color-purple-50: #faf5ff;
            --color-purple-100: #f3e8ff;
            --color-purple-200: #e9d5ff;
            --color-purple-300: #d8b4fe;
            --color-purple-400: #c084fc;
            --color-purple-500: #a855f7;
            --color-purple-600: #9333ea;
            --color-purple-700: #7e22ce;
            --color-purple-800: #6b21a8;
            --color-purple-900: #581c87;
            --color-purple-950: #3b0764;
            
            --color-yellow-50: #fefce8;
            --color-yellow-100: #fef9c3;
            --color-yellow-200: #fef08a;
            --color-yellow-300: #fde047;
            --color-yellow-400: #facc15;
            --color-yellow-500: #eab308;
            --color-yellow-600: #ca8a04;
            --color-yellow-700: #a16207;
            --color-yellow-800: #854d0e;
            --color-yellow-900: #713f12;
            --color-yellow-950: #422006;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="p-3 d-flex align-items-center mb-3">
                <img src="{{ asset('img/logo-pitaloka.jpeg') }}" alt="Logo" class="me-2" width="40" height="40">
                <span class="fw-bold text-white fs-5">Pitaloka AMS</span>
            </div>
            <div class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-speedometer2"></i></div>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.members.index') }}" class="menu-item {{ request()->routeIs('admin.members*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-people"></i></div>
                    <span>Manajemen Anggota</span>
                </a>
                <a href="{{ route('admin.districts.index') }}" class="menu-item {{ request()->routeIs('admin.districts*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-building"></i></div>
                    <span>Manajemen Distrik</span>
                </a>
                <a href="{{ route('admin.proposals.index') }}" class="menu-item {{ request()->routeIs('admin.proposals*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="bi bi-calendar-event"></i></div>
                    <span>Proposal Kegiatan</span>
                </a>
                <div class="mt-auto">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="menu-icon"><i class="bi bi-box-arrow-left"></i></div>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </nav>
        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <!-- Topbar -->
            <header class="admin-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button id="toggle-menu" class="toggle-menu">
                        <i class="bi bi-list"></i>
                    </button>
                    <h1 class="page-title mb-0">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="profile-dropdown position-relative">
                    <button class="profile-btn" id="profile-btn" type="button">
                        <div class="profile-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="profile-name">{{ Auth::user()->name }}</div>
                        <i class="bi bi-chevron-down ms-1"></i>
                    </button>
                    <div class="dropdown-content" id="profile-dropdown">
                        <form id="dropdown-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('dropdown-logout-form').submit();">
                            <i class="bi bi-box-arrow-left dropdown-icon"></i> Logout
                        </a>
                    </div>
                </div>
            </header>
            <!-- Page Content -->
            <div class="container-fluid py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar
        document.getElementById('toggle-menu').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('main-content').classList.toggle('expanded');
        });
        // Toggle profile dropdown
        document.getElementById('profile-btn').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('profile-dropdown').classList.toggle('show');
        });
        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            if (!document.getElementById('profile-btn').contains(e.target)) {
                var dropdown = document.getElementById('profile-dropdown');
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
