<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota - TA-AMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #faf7ff;
            font-family: 'Poppins', sans-serif;
            color: #1e1b4b;
        }
        
        /* Sidebar dengan warna ungu - dengan gradient yang lebih menarik */
        .sidebar {
            background: linear-gradient(180deg, #3b0764, #581c87);
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
        
        .sidebar.collapsed .menu-item span {
            display: none;
            opacity: 0;
            width: 0;
        }
        
        .sidebar.collapsed .menu-item {
            padding: 12px;
            display: flex;
            justify-content: center;
        }
        
        .sidebar.collapsed .menu-item.active {
            border-left: none;
            border-right: 3px solid #eab308;
        }
        
        .sidebar.collapsed .logo-text {
            display: none;
        }
        
        .sidebar.collapsed .menu-item i {
            margin-right: 0 !important;
            font-size: 1.25rem;
        }
        
        .logo {
            padding: 20px 15px;
            background-color: rgba(0, 0, 0, 0.2);
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 15px;
            position: relative;
            overflow: hidden;
        }
        
        .logo::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 10%;
            width: 80%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        }
        
        .logo-text {
            background: linear-gradient(45deg, #fff, #eab308);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .menu-item {
            padding: 12px 20px;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
            margin: 4px 8px;
            border-radius: 8px;
            position: relative;
        }
        
        /* Warna untuk card */
        .card-purple {
            border-top: 3px solid #9333ea;
        }
        
        .card-yellow {
            border-top: 3px solid #eab308;
        }
        
        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(3px);
        }
        
        .menu-item:not(.active):hover::after {
            content: '';
            position: absolute;
            left: -3px;
            top: 0;
            height: 100%;
            width: 3px;
            background-color: #eab308;
            opacity: 0.6;
        }
        
        .menu-item.active {
            background-color: #eab308;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: #ca8a04;
        }
        
        .menu-item.active .menu-link,
        .menu-item.active button {
            color: #3b0764;
            font-weight: 600;
        }
        
        .menu-link, .menu-item button {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            font-weight: 500;
        }
        
        .menu-item i {
            font-size: 1.1rem;
            min-width: 24px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .menu-item.active i {
            color: #3b0764;
        }
        
        .menu-item span {
            transition: all 0.3s ease;
            opacity: 1;
            white-space: nowrap;
        }
        
        .content-wrapper {
            margin-left: 250px;
            padding: 25px 30px;
            width: calc(100% - 250px);
            transition: all 0.3s ease;
        }
        
        .content-wrapper.expanded {
            margin-left: 60px;
            width: calc(100% - 60px);
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
            .content-wrapper, .content-wrapper.expanded {
                margin-left: 0 !important;
                width: 100%;
                padding: 10px;
            }
        }
        
        .toggle-sidebar-btn {
            background: transparent;
            border: none;
            color: #6b21a8;
            cursor: pointer;
            font-size: 1.2rem;
            margin-right: 15px;
            padding: 8px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            width: 40px;
            height: 40px;
            position: relative;
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .toggle-sidebar-btn:hover {
            background-color: rgba(107, 33, 168, 0.15);
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }
        
        .toggle-sidebar-btn:active {
            transform: translateY(1px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .toggle-sidebar-btn i {
            transition: transform 0.3s ease;
        }
        
        .sidebar:not(.collapsed) ~ .content-wrapper .toggle-sidebar-btn i {
            transform: rotate(180deg);
        }
        
        .page-title {
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9d5ff;
            color: #6b21a8;
        }
        
        /* Cards dengan sedikit shadow dan border */
        .card {
            box-shadow: 0 0.125rem 0.5rem rgba(88, 28, 135, 0.1);
            margin-bottom: 20px;
            border-radius: 0.5rem;
            border: none;
            transition: all 0.3s ease;
            background-color: #fff;
        }
        
        .card:hover {
            box-shadow: 0 0.25rem 1rem rgba(88, 28, 135, 0.15);
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f3e8ff;
            padding: 15px 20px;
            font-weight: 600;
            color: #6b21a8;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }
        
        .member-photo {
            max-width: 150px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(88, 28, 135, 0.2);
        }
        
        /* Welcome card dengan gradien ungu-kuning */
        .welcome-card {
            background: linear-gradient(135deg, var(--color-purple-600), var(--color-purple-800));
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(88, 28, 135, 0.2);
        }
        
        /* Badge styles */
        .badge.bg-success, .badge-purple {
            background-color: #9333ea !important;
            color: white;
        }
        
        .badge.bg-danger, .badge-yellow {
            background-color: #ca8a04 !important;
            color: #581c87;
        }
        
        /* Button styles */
        .btn-primary, .btn-purple {
            background-color: #9333ea;
            border-color: #7e22ce;
            color: white;
        }
        
        .btn-primary:hover, .btn-purple:hover {
            background-color: #7e22ce;
            border-color: #6b21a8;
            color: white;
        }
        
        .btn-yellow {
            background-color: #eab308;
            border-color: #ca8a04;
            color: #581c87;
        }
        
        .btn-yellow:hover {
            background-color: #ca8a04;
            border-color: #a16207;
            color: #581c87;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="logo d-flex justify-content-between align-items-center">
                <span class="logo-text">TA-AMS</span>
                <button class="btn toggle-sidebar-btn d-md-none" id="closeSidebarBtn">
                    <i class="bi bi-x-lg text-white"></i>
                </button>
            </div>
            <div class="menu">
                <div class="menu-item active">
                    <a href="{{ route('member.dashboard') }}" class="menu-link">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('member.profile') }}" class="menu-link">
                        <i class="bi bi-person me-2"></i> Profil Saya
                    </a>
                </div>
                {{-- Hapus tombol logout dari sidebar --}}
                {{-- <div class="menu-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="menu-link bg-transparent border-0 w-100 text-start">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div> --}}
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <!-- Top Bar -->
                <div class="top-bar mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <button class="toggle-sidebar-btn me-3" id="toggleSidebarBtn">
                                <i class="bi bi-list fs-4"></i>
                            </button>
                            <h1 class="mb-0">Dashboard Anggota</h1>
                        </div>
                        <!-- Tombol logout di kanan atas -->
                        <div>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <!-- Welcome Card -->
                <div class="welcome-card position-relative overflow-hidden" style="background: linear-gradient(135deg, #9333ea, #7e22ce); color: white; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 5px 15px rgba(88, 28, 135, 0.2);">
                    <div class="position-absolute" style="top: -20px; right: -20px; width: 150px; height: 150px; background-color: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div class="position-absolute" style="bottom: -40px; left: -20px; width: 180px; height: 180px; background-color: rgba(255,255,255,0.05); border-radius: 50%;"></div>
                    
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold">Selamat Datang, {{ $user->name }}!</h2>
                            @if(isset($member))
                                <p class="opacity-75 mb-2">ID Anggota: {{ $member->member_id }}</p>
                                <p class="mb-0"><i class="bi bi-geo-alt me-2"></i>{{ $member->district->name ?? 'Belum terdaftar' }}</p>
                            @else
                                <p class="opacity-75 mb-2">Akun belum terhubung dengan data anggota</p>
                            @endif
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            @if(isset($member))
                                <a href="{{ route('member.download-kta') }}" class="btn btn-yellow" style="background-color: #eab308; color: #581c87;">
                                    <i class="bi bi-download me-2"></i> Download KTA
                                </a>
                            @else
                                <button class="btn btn-secondary" disabled>
                                    <i class="bi bi-download me-2"></i> Download KTA
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="row gx-4">
                    @if(isset($member))
                    <div class="col-md-4">
                        <div class="card card-hover card-purple">
                            <div class="card-header d-flex align-items-center">
                                <i class="bi bi-info-circle me-2 text-purple-600"></i>
                                <h5 class="mb-0 header-purple">Informasi Anggota</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-bold">Nama</div>
                                    <div class="col-md-8">{{ $member->name }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-bold">Distrik</div>
                                    <div class="col-md-8">{{ $member->district->name ?? 'Belum terdaftar' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-bold">Tgl Daftar</div>
                                    <div class="col-md-8">{{ $member->registration_date ? $member->registration_date->format('d/m/Y') : '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-bold">Berlaku s/d</div>
                                    <div class="col-md-8">{{ $member->expiry_date ? $member->expiry_date->format('d/m/Y') : '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-bold">Status</div>
                                    <div class="col-md-8">
                                        @if($member->status == 'active')
                                            <span class="badge badge-purple">Aktif</span>
                                        @else
                                            <span class="badge badge-yellow">Tidak Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card card-hover card-yellow">
                            <div class="card-header d-flex align-items-center">
                                <i class="bi bi-person-badge me-2 text-yellow-600"></i>
                                <h5 class="mb-0 header-yellow">Foto Anggota</h5>
                            </div>
                            <div class="card-body text-center">
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto {{ $member->name }}" class="img-fluid member-photo">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                        <i class="bi bi-person-bounding-box" style="font-size: 5rem; color: #ccc;"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    
                    @else
                    <div class="col-md-12">
                        <div class="card card-hover card-purple">
                            <div class="card-header d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle me-2 text-purple-600"></i>
                                <h5 class="mb-0 header-purple">Data Anggota Tidak Ditemukan</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <p class="mb-0">Akun Anda belum terhubung dengan data anggota. Mohon hubungi administrator untuk memverifikasi dan mengaitkan akun Anda dengan data keanggotaan.</p>
                                </div>
                                <hr>
                                <h5>Langkah yang dapat Anda lakukan:</h5>
                                <ol>
                                    <li>Pastikan Anda telah terdaftar sebagai anggota</li>
                                    <li>Hubungi administrator melalui kontak yang tersedia</li>
                                    <li>Berikan informasi email atau username yang Anda gunakan untuk login</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.querySelector('.content-wrapper');
            const toggleBtn = document.getElementById('toggleSidebarBtn');
            const closeBtn = document.getElementById('closeSidebarBtn');
            
            // Check for saved state in localStorage - use a specific key for member sidebar
            const sidebarState = localStorage.getItem('memberSidebarState');
            if (sidebarState === 'collapsed') {
                sidebar.classList.add('collapsed');
                contentWrapper.classList.add('expanded');
            }
            
            // Toggle sidebar function
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                contentWrapper.classList.toggle('expanded');
                
                // Save state to localStorage with member-specific key
                if (sidebar.classList.contains('collapsed')) {
                    localStorage.setItem('memberSidebarState', 'collapsed');
                } else {
                    localStorage.setItem('memberSidebarState', 'expanded');
                }
            }
            
            // Add touch event for mobile
            document.addEventListener('touchstart', function(e) {
                // If sidebar is open and user taps outside sidebar and toggle button on mobile
                if (window.innerWidth < 768 && 
                    !sidebar.classList.contains('collapsed') && 
                    !sidebar.contains(e.target) && 
                    !toggleBtn.contains(e.target)) {
                    toggleSidebar();
                }
            });
            
            // Event listeners
            if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        });
    </script>
</body>
</html>
