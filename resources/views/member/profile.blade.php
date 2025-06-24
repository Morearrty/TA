<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - TA-AMS</title>
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
            background-color: rgba(107, 33, 168, 0.1);
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
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(0);
            }
            
            .sidebar.collapsed {
                transform: translateX(-100%);
                width: 250px;
            }
            
            .content-wrapper {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            
            .content-wrapper.expanded {
                margin-left: 0;
                width: 100%;
            }
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px 0;
        }
        
        .top-bar-right {
            display: flex;
            align-items: center;
        }
        .page-title {
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9d5ff;
            color: #6b21a8;
        }
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
        .profile-photo {
            max-width: 200px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(88, 28, 135, 0.2);
        }
        .profile-info {
            padding: 20px;
        }
        .card-purple {
            border-top: 3px solid #9333ea;
        }
        .card-yellow {
            border-top: 3px solid #eab308;
        }
        .badge-purple {
            background-color: #9333ea !important;
            color: white;
        }
        .badge-yellow {
            background-color: #ca8a04 !important;
            color: #581c87;
        }
        .btn-purple {
            background-color: #9333ea;
            border-color: #7e22ce;
            color: white;
        }
        .btn-purple:hover {
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
        .main-content {
            margin-left: 250px;
            transition: all 0.3s ease;
            padding: 20px;
            min-height: 100vh;
        }
        .main-content.expanded {
            margin-left: 60px;
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
                <div class="menu-item">
                    <a href="{{ route('member.dashboard') }}" class="menu-link">
                        <i class="bi bi-speedometer2 me-2"></i> <span>Dashboard</span>
                    </a>
                </div>
                <div class="menu-item active">
                    <a href="{{ route('member.profile') }}" class="menu-link">
                        <i class="bi bi-person me-2"></i> <span>Profil Saya</span>
                    </a>
    </div> 
                <div class="menu-item">
                    <a href="/" class="menu-link">
                        <i class="bi bi-house-door me-2"></i> <span>Kembali ke Website</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <!-- Top Bar -->
                <div class="top-bar">
                    <div class="d-flex align-items-center">
                        <button class="toggle-sidebar-btn me-3" id="toggleSidebarBtn">
                            <i class="bi bi-list fs-4"></i>
                        </button>
                        <h1 class="mb-0">Profil Saya</h1>
                    </div>
                    <div class="top-bar-right">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-purple">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
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
                
                <!-- Main Content -->
                <div class="row gx-4">
                    <div class="col-md-3">
                        <div class="card card-purple">
                            <div class="card-body text-center">
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="img-thumbnail rounded-circle mx-auto" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="img-thumbnail rounded-circle mx-auto" style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                                <h5 class="mt-3">{{ $member->name }}</h5>
                                <p class="text-muted mb-3">ID: {{ $member->member_id }}</p>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('member.edit-profile') }}" class="btn btn-purple">
                                        <i class="bi bi-pencil-square me-1"></i> Edit Profil
                                    </a>
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <button type="button" class="btn btn-purple btn-sm" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                                        <i class="bi bi-camera-fill me-1"></i> Update Foto
                                    </button>
                                    <a href="{{ route('member.download-kta') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-download me-1"></i> Download KTA
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-9">
                        <div class="card card-purple">
                            <div class="card-header d-flex align-items-center">
                                <i class="bi bi-person-vcard me-2 text-purple-600"></i>
                                <h5 class="mb-0 header-purple">Informasi Pribadi</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">ID Anggota</div>
                                    <div class="col-md-8">{{ $member->member_id }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Nama Lengkap</div>
                                    <div class="col-md-8">{{ $member->name }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">NIK</div>
                                    <div class="col-md-8">{{ $member->nik }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Email</div>
                                    <div class="col-md-8">{{ $member->email ?? '-' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Nomor Telepon</div>
                                    <div class="col-md-8">{{ $member->phone_number ?? '-' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Alamat</div>
                                    <div class="col-md-8">{{ $member->address ?? '-' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Tempat, Tanggal Lahir</div>
                                    <div class="col-md-8">
                                        @if($member->place_of_birth || $member->date_of_birth)
                                            {{ $member->place_of_birth ?? '' }}
                                            @if($member->place_of_birth && $member->date_of_birth), @endif
                                            {{ $member->date_of_birth ? $member->date_of_birth->format('d/m/Y') : '' }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Jenis Kelamin</div>
                                    <div class="col-md-8">
                                        @if($member->gender == 'male')
                                            Laki-laki
                                        @elseif($member->gender == 'female')
                                            Perempuan
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card card-yellow">
                            <div class="card-header d-flex align-items-center">
                                <i class="bi bi-card-checklist me-2 text-yellow-600"></i>
                                <h5 class="mb-0 header-yellow">Informasi Keanggotaan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Distrik/Cabang</div>
                                    <div class="col-md-8">{{ $member->district->name }} ({{ $member->district->code }})</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Tanggal Pendaftaran</div>
                                    <div class="col-md-8">{{ $member->registration_date->format('d/m/Y') }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Berlaku Hingga</div>
                                    <div class="col-md-8">{{ $member->expiry_date->format('d/m/Y') }}</div>
                                </div>
                                <div class="row mb-3">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Upload Modal -->
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-purple text-white">
                    <h5 class="modal-title" id="uploadPhotoModalLabel">Update Foto Profil</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('member.update-photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="photo-preview-container mb-3">
                                @if($member->photo)
                                    <img id="photoPreview" src="{{ asset('storage/' . $member->photo) }}" class="img-thumbnail" style="max-width: 200px; max-height: 250px;">
                                @else
                                    <img id="photoPreview" src="{{ asset('images/default-profile.png') }}" class="img-thumbnail" style="max-width: 200px; max-height: 250px;">
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Pilih Foto Baru</label>
                                <input class="form-control" type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg" required>
                                <div class="form-text text-muted">Format: JPG, JPEG, atau PNG. Maksimal ukuran 2MB.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-purple">Simpan Foto</button>
                    </div>
                </form>
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
            
            // Check for saved state in localStorage
            const sidebarState = localStorage.getItem('memberSidebarState');
            if (sidebarState === 'collapsed') {
                sidebar.classList.add('collapsed');
                contentWrapper.classList.add('expanded');
            }
            
            // Toggle sidebar function
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                contentWrapper.classList.toggle('expanded');
                
                // Save state to localStorage
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
            
            // Photo preview functionality
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photoPreview');
            
            photoInput?.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
</body>
</html>
