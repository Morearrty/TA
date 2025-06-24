<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kegiatan - TA-AMS</title>
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
            border-radius: 4px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        
        .menu-item i {
            margin-right: 10px;
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
        }
        
        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
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
        
        .menu-item.active i,
        .menu-item.active span {
            color: #1e1b4b;
            font-weight: 500;
        }
        
        .menu-link {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%;
        }
        
        .menu-item:hover .menu-link {
            color: white;
        }
        
        .menu-item.active .menu-link {
            color: #1e1b4b;
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
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f3e8ff;
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #6b21a8;
            margin-bottom: 0;
        }
        
        .card {
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
        
        .card-body {
            padding: 20px;
        }
        
        .header-purple {
            color: #6b21a8;
        }
        
        .header-yellow {
            color: #a16207;
        }
        
        .text-purple-600 {
            color: #9333ea;
        }
        
        .text-yellow-600 {
            color: #ca8a04;
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
                <div class="menu-item">
                    <a href="{{ route('member.dashboard') }}" class="menu-link">
                        <i class="bi bi-speedometer2 me-2"></i> <span>Dashboard</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('member.profile') }}" class="menu-link">
                        <i class="bi bi-person me-2"></i> <span>Profil Saya</span>
                    </a>
                </div>
                <div class="menu-item active">
                    <a href="{{ route('district.proposals.index') }}" class="menu-link">
                        <i class="bi bi-file-earmark-text me-2"></i> <span>Pengajuan Kegiatan</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('logout') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i> <span>Keluar</span>
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <div class="menu-item">
                    <a href="/" class="menu-link">
                        <i class="bi bi-house-door me-2"></i> <span>Kembali ke Website</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="content-wrapper" id="content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="d-flex align-items-center">
                    <button class="toggle-sidebar-btn d-none d-md-block" id="toggleSidebarBtn">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="page-title mb-0 ms-md-2">Detail Kegiatan</h4>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="header-purple mb-0">Detail Pengajuan Kegiatan</h5>
                    <div>
                        @if($proposal->status == 'pending')
                            <a href="{{ route('district.proposals.edit', $proposal->id) }}" class="btn btn-warning me-2">Edit</a>
                        @endif
                        <a href="{{ route('district.proposals.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
                <div class="card-body">
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

                    <div class="alert 
                        @if($proposal->status == 'pending') alert-warning
                        @elseif($proposal->status == 'approved') alert-success
                        @else alert-danger @endif">
                        <strong>Status:</strong> 
                        @if($proposal->status == 'pending')
                            Pending Review
                        @elseif($proposal->status == 'approved')
                            Approved on {{ $proposal->approval_date->format('d M Y') }}
                        @else
                            Rejected on {{ $proposal->updated_at->format('d M Y') }}
                        @endif
                    </div>

                    @if($proposal->status == 'rejected')
                        <div class="alert alert-danger">
                            <h5>Rejection Reason:</h5>
                            <p>{{ $proposal->rejection_reason }}</p>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Basic Information</h5>
                            <table class="table">
                                <tr>
                                    <th width="150">Title</th>
                                    <td>{{ $proposal->title }}</td>
                                </tr>
                                <tr>
                                    <th>District</th>
                                    <td>{{ $proposal->district->name }}</td>
                                </tr>
                                <tr>
                                    <th>Submitted</th>
                                    <td>{{ $proposal->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Activity Details</h5>
                            <table class="table">
                                <tr>
                                    <th width="150">Start Date</th>
                                    <td>{{ $proposal->start_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $proposal->end_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td>{{ $proposal->location ?? 'N/A' }}</td>
                                </tr>

                            </table>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5>Description</h5>
                            <div class="card">
                                <div class="card-body">
                                    {!! nl2br(e($proposal->description)) !!}
                                </div>
                            </div>
                        </div>
                    </div>



                    @if($proposal->status == 'pending')
                        <div class="d-flex justify-content-end mt-3">
                            <form action="{{ route('district.proposals.destroy', $proposal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this proposal? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Proposal</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const toggleBtn = document.getElementById('toggleSidebarBtn');
            const closeBtn = document.getElementById('closeSidebarBtn');
            
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
            });
            
            closeBtn.addEventListener('click', function() {
                sidebar.classList.add('collapsed');
                content.classList.remove('expanded');
            });
            
            // On mobile, collapse sidebar by default
            function checkWidth() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('collapsed');
                    content.classList.add('expanded');
                }
            }
            
            window.addEventListener('resize', checkWidth);
            checkWidth(); // Initial check
        });
    </script>
</body>
</html>
