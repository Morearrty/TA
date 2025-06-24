<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pitaloka AMS - Sistem Manajemen Anggota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            // Ungu
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#581c87',
                            950: '#3b0764',
                        },
                        secondary: {
                            // Kuning
                            50: '#fefce8',
                            100: '#fef9c3',
                            200: '#fef08a',
                            300: '#fde047',
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                            700: '#a16207',
                            800: '#854d0e',
                            900: '#713f12',
                            950: '#422006',
                        }
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer utilities {
            .text-shadow {
                text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .text-shadow-lg {
                text-shadow: 0 4px 8px rgba(0,0,0,0.2);
            }
        }
    </style>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <!-- Tambahkan file CSS kustom (tidak wajib) -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="font-poppins bg-gray-50">
    <!-- Modern Navigation dengan Tailwind -->
    <nav class="bg-gray-900 text-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo dan Brand -->
                <a href="{{ route('welcome') }}" class="flex items-center space-x-2 text-xl font-bold">
                    <img src="{{ asset('img/logo-pitaloka.jpeg') }}" alt="Pitaloka Logo" class="h-10 w-10">
                    <span>Pitaloka AMS</span>
                </a>
                
                <!-- Menu Hamburger untuk Mobile -->
                <div class="md:hidden">
                    <button id="menu-toggle" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
                
                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center justify-between flex-grow ml-10">
                    <ul class="flex space-x-6">
                        <li>
                            <a href="{{ route('welcome') }}" class="text-white hover:text-primary-300 py-2 transition duration-300 border-b-2 border-transparent hover:border-primary-400">Beranda</a>
                        </li>
                        <li>
                            <a href="#about-section" class="text-white hover:text-primary-300 py-2 transition duration-300 border-b-2 border-transparent hover:border-primary-400">Tentang Kami</a>
                        </li>
                        <li>
                            <a href="#gallery-section" class="text-white hover:text-primary-300 py-2 transition duration-300 border-b-2 border-transparent hover:border-primary-400">Galeri</a>
                        </li>
                        <li>
                            <a href="{{ route('anggota.daftar') }}" class="text-white hover:text-primary-300 py-2 transition duration-300 border-b-2 border-transparent hover:border-primary-400">Pendaftaran</a>
                        </li>
                    </ul>
                    
                    <div class="flex items-center space-x-3">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-white text-white hover:bg-white hover:text-gray-900 rounded-md transition duration-300">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                                </a>
                            @else
                                <a href="{{ route('member.dashboard') }}" class="px-4 py-2 border border-white text-white hover:bg-white hover:text-gray-900 rounded-md transition duration-300">
                                    <i class="fas fa-user mr-2"></i> Dashboard Anggota
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white rounded-md transition duration-300">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 border border-white text-white hover:bg-white hover:text-gray-900 rounded-md transition duration-300">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login Anggota
                            </a>
                            <a href="{{ route('admin.login') }}" class="px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white rounded-md transition duration-300">
                                <i class="fas fa-shield-alt mr-2"></i> Admin
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Menu Mobile (Initially Hidden) -->
            <div id="mobile-menu" class="md:hidden hidden pt-4 pb-2">
                <ul class="flex flex-col space-y-3">
                    <li>
                        <a href="{{ route('welcome') }}" class="block text-white hover:text-primary-300 py-2">Beranda</a>
                    </li>
                    <li>
                        <a href="#about-section" class="block text-white hover:text-primary-300 py-2">Tentang Kami</a>
                    </li>
                    <li>
                        <a href="#gallery-section" class="block text-white hover:text-primary-300 py-2">Galeri</a>
                    </li>
                    <li>
                        <a href="{{ route('anggota.daftar') }}" class="block text-white hover:text-primary-300 py-2">Pendaftaran</a>
                    </li>
                </ul>
                <div class="mt-4 flex flex-col space-y-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-white text-white hover:bg-white hover:text-gray-900 rounded-md transition duration-300 text-center">
                                <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                            </a>
                        @else
                            <a href="{{ route('member.dashboard') }}" class="px-4 py-2 border border-white text-white hover:bg-white hover:text-gray-900 rounded-md transition duration-300 text-center">
                                <i class="fas fa-user mr-2"></i> Dashboard Anggota
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white rounded-md transition duration-300">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 border border-white text-white hover:bg-white hover:text-gray-900 rounded-md transition duration-300 text-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login Anggota
                        </a>
                        <a href="{{ route('admin.login') }}" class="px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white rounded-md transition duration-300 text-center">
                            <i class="fas fa-shield-alt mr-2"></i> Admin
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <script>
        // Skrip untuk toggle menu mobile
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    
    <!-- Chart.js untuk membuat pie chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Hero Section dengan Tailwind yang lebih menarik -->
    <section class="relative bg-gradient-to-r from-primary-800 via-primary-700 to-primary-900 text-white py-24 overflow-hidden">
        <!-- Lingkaran dekoratif di background dengan animasi -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full transform translate-x-1/3 -translate-y-1/3 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full transform -translate-x-1/3 translate-y-1/3 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-48 h-48 bg-secondary-500 opacity-5 rounded-full blur-2xl animate-pulse" style="animation-delay: 1.5s;"></div>
        <div class="absolute bottom-1/4 right-1/3 w-32 h-32 bg-secondary-300 opacity-5 rounded-full blur-xl animate-pulse" style="animation-delay: 2s;"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between max-w-6xl mx-auto">
                <div class="text-left mb-10 md:mb-0 md:w-1/2">
                    <div class="inline-block px-4 py-1 bg-white/10 backdrop-blur-sm rounded-full text-sm font-semibold mb-4 border border-white/20 text-white/90">
                        <span class="animate-pulse inline-block w-2 h-2 bg-secondary-400 rounded-full mr-2"></span>Sistem Manajemen Anggota Modern
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 text-shadow-lg bg-clip-text text-transparent bg-gradient-to-r from-white via-white to-secondary-200">
                        {{ $sections['hero']['title'] ?? 'Pitaloka AMS' }}
                    </h1>
                    <p class="text-xl opacity-90 mb-10 leading-relaxed">
                        {{ $sections['hero']['subtitle'] ?? 'Sistem manajemen anggota modern untuk pendaftaran, pengelolaan kegiatan, dan administrasi keanggotaan yang efisien dan terpadu' }}
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('anggota.daftar') }}" class="px-8 py-3 bg-gradient-to-r from-secondary-500 to-secondary-600 text-primary-900 font-bold rounded-full uppercase tracking-wide shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i> {{ $sections['hero']['register_button'] ?? 'Daftar Menjadi Anggota' }}
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-3 border-2 border-white/80 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/10 transition duration-300 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> {{ $sections['hero']['login_button'] ?? 'Login Anggota' }}
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-primary-600/20 backdrop-blur-sm rounded-2xl transform rotate-6"></div>
                        <img src="{{ asset('img/logo-pitaloka.jpeg') }}" alt="Logo Pitaloka" class="relative z-10 w-full max-w-md mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- About Section dengan Tailwind -->
    <section class="py-20 bg-white" id="about-section">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-4">{{ $sections['about']['title'] ?? 'Tentang Pitaloka AMS' }}</h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">{{ $sections['about']['description'] ?? 'Pitaloka Association Management System (AMS) adalah sistem manajemen anggota yang dirancang untuk memudahkan proses pendaftaran, pengelolaan, dan administrasi anggota organisasi.' }}</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <div>
                    <div class="bg-gray-50 rounded-xl shadow-md p-8 h-full hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                        <h4 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                            <i class="fas fa-eye mr-3 text-primary-600"></i> {{ $sections['about']['vision_title'] ?? 'Visi' }}
                        </h4>
                        <p class="text-gray-600">{{ $sections['about']['vision_text'] ?? 'Menjadi sistem manajemen anggota terdepan yang memudahkan organisasi dalam mengelola anggota dan meningkatkan efisiensi administrasi keanggotaan di berbagai jenis organisasi.' }}</p>
                    </div>
                </div>
                <div>
                    <div class="bg-gray-50 rounded-xl shadow-md p-8 h-full hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                        <h4 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                            <i class="fas fa-bullseye mr-3 text-primary-600"></i> {{ $sections['about']['mission_title'] ?? 'Misi' }}
                        </h4>
                        <p class="text-gray-600">{{ $sections['about']['mission_text'] ?? 'Membangun platform yang mudah digunakan dan komprehensif untuk mendukung pengelolaan anggota, mengotomatisasi proses administratif, dan memfasilitasi komunikasi antar anggota organisasi.' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <div class="bg-gray-50 rounded-xl shadow-md p-8 h-full hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                        <h4 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                            <i class="fas fa-users mr-3 text-primary-600"></i> {{ $sections['about']['feature1_title'] ?? 'Pendaftaran Anggota' }}
                        </h4>
                        <p class="text-gray-600">{{ $sections['about']['feature1_text'] ?? 'Proses pendaftaran yang mudah dan cepat dengan pembuatan Kartu Tanda Anggota (KTA) otomatis yang dapat diunduh dan dicetak.' }}</p>
                    </div>
                </div>
                <div>
                    <div class="bg-gray-50 rounded-xl shadow-md p-8 h-full hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                        <h4 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt mr-3 text-primary-600"></i> {{ $sections['about']['feature2_title'] ?? 'Manajemen Distrik' }}
                        </h4>
                        <p class="text-gray-600">{{ $sections['about']['feature2_text'] ?? 'Pengelolaan anggota berdasarkan distrik atau cabang wilayah untuk memudahkan koordinasi dan pengorganisasian kegiatan.' }}</p>
                    </div>
                </div>
                <div>
                    <div class="bg-gray-50 rounded-xl shadow-md p-8 h-full hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                        <h4 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                            <i class="fas fa-file-alt mr-3 text-primary-600"></i> {{ $sections['about']['feature3_title'] ?? 'Pengajuan Kegiatan' }}
                        </h4>
                        <p class="text-gray-600">{{ $sections['about']['feature3_text'] ?? 'Sistem pengajuan kegiatan dan anggaran yang transparan dan efisien untuk mendukung aktivitas organisasi di setiap distrik.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    
    <!-- Statistics Section dengan Pie Chart -->
    <section class="py-20 bg-gray-50" id="statistics-section">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-4">Statistik Keanggotaan</h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">Visualisasi data anggota berdasarkan distribusi wilayah</p>
            </div>
            
            <div class="flex flex-wrap justify-center items-center">
                <div class="w-full md:w-1/2 mb-10 md:mb-0">
                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                        <h3 class="text-xl font-semibold text-primary-700 mb-4 text-center">Distribusi Anggota per Distrik</h3>
                        <div class="relative" style="height: 350px;">
                            <canvas id="districtChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="w-full md:w-1/2 md:pl-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-lg text-center transform transition-transform hover:-translate-y-1 hover:shadow-xl">
                            <div class="text-primary-600 text-4xl mb-2">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4 class="text-gray-700 text-lg font-semibold mb-1">Total Anggota</h4>
                            <p class="text-4xl font-bold text-primary-700">{{ \App\Models\Member::count() }}</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-2xl shadow-lg text-center transform transition-transform hover:-translate-y-1 hover:shadow-xl">
                            <div class="text-primary-600 text-4xl mb-2">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <h4 class="text-gray-700 text-lg font-semibold mb-1">Anggota Aktif</h4>
                            <p class="text-4xl font-bold text-primary-700">{{ \App\Models\Member::where('status', 'active')->count() }}</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-2xl shadow-lg text-center transform transition-transform hover:-translate-y-1 hover:shadow-xl">
                            <div class="text-secondary-600 text-4xl mb-2">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h4 class="text-gray-700 text-lg font-semibold mb-1">Total Distrik</h4>
                            <p class="text-4xl font-bold text-primary-700">{{ \App\Models\District::count() }}</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-2xl shadow-lg text-center transform transition-transform hover:-translate-y-1 hover:shadow-xl">
                            <div class="text-secondary-600 text-4xl mb-2">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h4 class="text-gray-700 text-lg font-semibold mb-1">Pendaftaran Baru</h4>
                            <p class="text-4xl font-bold text-primary-700">{{ \App\Models\Member::where('registration_date', '>=', now()->subDays(30))->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Gallery Section dengan Tailwind -->
    <section class="py-20 bg-white" id="gallery-section">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-4">{{ $sections['gallery']['title'] ?? 'Galeri Kegiatan' }}</h2>
                <p class="text-xl text-gray-600">{{ $sections['gallery']['subtitle'] ?? 'Dokumentasi kegiatan-kegiatan yang telah dilaksanakan oleh anggota organisasi' }}</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Item Galeri Utama -->
                <div class="md:col-span-2 overflow-hidden rounded-xl shadow-lg relative group">
                    @if(isset($sections['gallery']['main_image']) && !empty($sections['gallery']['main_image']))
                        @if(Str::startsWith($sections['gallery']['main_image'], 'http'))
                            <img src="{{ $sections['gallery']['main_image'] }}" class="w-full h-80 object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['main_title'] ?? 'Konferensi Tahunan' }}">
                        @else
                            <img src="{{ asset('storage/'.$sections['gallery']['main_image']) }}" class="w-full h-80 object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['main_title'] ?? 'Konferensi Tahunan' }}">
                        @endif
                    @else
                        <img src="https://source.unsplash.com/random/1200x600/?conference" class="w-full h-80 object-cover transition-all duration-500 group-hover:scale-105" alt="Konferensi Tahunan">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-80 flex flex-col justify-end p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">{{ $sections['gallery']['main_title'] ?? 'Konferensi Tahunan' }}</h3>
                        <p class="text-white/90">{{ $sections['gallery']['main_description'] ?? 'Pertemuan anggota dalam konferensi tahunan organisasi untuk mendiskusikan perkembangan dan rencana ke depan' }}</p>
                    </div>
                </div>
                
                <!-- Item Galeri Lainnya -->
                <div class="space-y-8">
                    <div class="overflow-hidden rounded-xl shadow-lg relative group h-36">
                        @if(isset($sections['gallery']['side_image1']) && !empty($sections['gallery']['side_image1']))
                            @if(Str::startsWith($sections['gallery']['side_image1'], 'http'))
                                <img src="{{ $sections['gallery']['side_image1'] }}" class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['side_title1'] ?? 'Workshop Pengembangan' }}">
                            @else
                                <img src="{{ asset('storage/'.$sections['gallery']['side_image1']) }}" class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['side_title1'] ?? 'Workshop Pengembangan' }}">
                            @endif
                        @else
                            <img src="https://source.unsplash.com/random/600x300/?workshop" class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105" alt="Workshop Pengembangan">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-4 text-white">
                            <h3 class="text-lg font-bold">{{ $sections['gallery']['side_title1'] ?? 'Workshop Pengembangan' }}</h3>
                        </div>
                    </div>
                    
                    <div class="overflow-hidden rounded-xl shadow-lg relative group h-36">
                        @if(isset($sections['gallery']['side_image2']) && !empty($sections['gallery']['side_image2']))
                            @if(Str::startsWith($sections['gallery']['side_image2'], 'http'))
                                <img src="{{ $sections['gallery']['side_image2'] }}" class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['side_title2'] ?? 'Kegiatan Sosial' }}">
                            @else
                                <img src="{{ asset('storage/'.$sections['gallery']['side_image2']) }}" class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['side_title2'] ?? 'Kegiatan Sosial' }}">
                            @endif
                        @else
                            <img src="https://source.unsplash.com/random/600x300/?community" class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105" alt="Kegiatan Sosial">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-4 text-white">
                            <h3 class="text-lg font-bold">{{ $sections['gallery']['side_title2'] ?? 'Kegiatan Sosial' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Grid Galeri Tambahan -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                <div class="overflow-hidden rounded-lg shadow-md relative group">
                    @if(isset($sections['gallery']['grid_image1']) && !empty($sections['gallery']['grid_image1']))
                        @if(Str::startsWith($sections['gallery']['grid_image1'], 'http'))
                            <img src="{{ $sections['gallery']['grid_image1'] }}" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['grid_title1'] ?? 'Pertemuan Anggota' }}">
                        @else
                            <img src="{{ asset('storage/'.$sections['gallery']['grid_image1']) }}" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['grid_title1'] ?? 'Pertemuan Anggota' }}">
                        @endif
                    @else
                        <img src="https://source.unsplash.com/random/300x200/?meeting" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="Pertemuan Anggota">
                    @endif
                </div>
                <div class="overflow-hidden rounded-lg shadow-md relative group">
                    @if(isset($sections['gallery']['grid_image2']) && !empty($sections['gallery']['grid_image2']))
                        @if(Str::startsWith($sections['gallery']['grid_image2'], 'http'))
                            <img src="{{ $sections['gallery']['grid_image2'] }}" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['grid_title2'] ?? 'Seminar Nasional' }}">
                        @else
                            <img src="{{ asset('storage/'.$sections['gallery']['grid_image2']) }}" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['grid_title2'] ?? 'Seminar Nasional' }}">
                        @endif
                    @else
                        <img src="https://source.unsplash.com/random/300x200/?seminar" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="Seminar Nasional">
                    @endif
                </div>
                <div class="overflow-hidden rounded-lg shadow-md relative group">
                    @if(isset($sections['gallery']['grid_image3']) && !empty($sections['gallery']['grid_image3']))
                        @if(Str::startsWith($sections['gallery']['grid_image3'], 'http'))
                            <img src="{{ $sections['gallery']['grid_image3'] }}" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['grid_title3'] ?? 'Pelatihan Anggota' }}">
                        @else
                            <img src="{{ asset('storage/'.$sections['gallery']['grid_image3']) }}" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['grid_title3'] ?? 'Pelatihan Anggota' }}">
                        @endif
                    @else
                        <img src="https://source.unsplash.com/random/300x200/?training" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="Pelatihan Anggota">
                    @endif
                </div>
                <div class="overflow-hidden rounded-lg shadow-md relative group">
                    @if(isset($sections['gallery']['grid_image4']) && !empty($sections['gallery']['grid_image4']))
                        @if(Str::startsWith($sections['gallery']['grid_image4'], 'http'))
                            <img src="{{ $sections['gallery']['grid_image4'] }}" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['grid_title4'] ?? 'Bakti Sosial' }}">
                        @else
                            <img src="{{ asset('storage/'.$sections['gallery']['grid_image4']) }}" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="{{ $sections['gallery']['grid_title4'] ?? 'Bakti Sosial' }}">
                        @endif
                    @else
                        <img src="https://source.unsplash.com/random/300x200/?charity" class="w-full h-40 object-cover transition-all duration-500 group-hover:scale-105" alt="Bakti Sosial">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section dengan Tailwind -->
    <section class="py-20 bg-gradient-to-r from-primary-700 to-primary-900 text-white relative overflow-hidden">
        <!-- Elemen dekoratif -->
        <div class="absolute -top-24 -right-24 w-64 h-64 rounded-full bg-white opacity-10 blur-xl"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-primary-600 opacity-20 blur-xl"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-shadow">{{ $sections['cta']['title'] ?? 'Bergabunglah Bersama Kami' }}</h2>
                <p class="text-xl opacity-90 mb-10">{{ $sections['cta']['subtitle'] ?? 'Menjadi bagian dari jaringan anggota kami dan dapatkan berbagai manfaat keanggotaan' }}</p>
                <a href="{{ route('anggota.daftar') }}" class="inline-block px-8 py-4 bg-white text-primary-700 rounded-full font-semibold uppercase tracking-wide shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    <i class="fas fa-user-plus mr-2"></i> {{ $sections['cta']['button_text'] ?? 'Daftar Sekarang' }}
                </a>
            </div>
        </div>
    </section>
    
    <!-- Login Section dengan Tailwind -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-4">{{ $sections['login']['title'] ?? 'Akses Sistem' }}</h2>
                <p class="text-xl text-gray-600">{{ $sections['login']['subtitle'] ?? 'Login ke sistem sesuai peran Anda' }}</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <div>
                    <div class="bg-white rounded-xl shadow-md p-8 text-center h-full transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                        <i class="fas fa-user-circle text-5xl text-primary-600 mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $sections['login']['member_title'] ?? 'Anggota' }}</h3>
                        <p class="text-gray-600 mb-8">{{ $sections['login']['member_description'] ?? 'Akses dashboard anggota untuk melihat informasi keanggotaan, mengunduh KTA, dan mengakses fitur anggota lainnya.' }}</p>
                        <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold transition duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i> {{ $sections['login']['member_button'] ?? 'Login Anggota' }}
                        </a>
                    </div>
                </div>
                <div>
                    <div class="bg-white rounded-xl shadow-md p-8 text-center h-full transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                        <i class="fas fa-shield-alt text-5xl text-secondary-600 mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $sections['login']['admin_title'] ?? 'Administrator' }}</h3>
                        <p class="text-gray-600 mb-8">{{ $sections['login']['admin_description'] ?? 'Akses dashboard admin untuk mengelola anggota, distrik, kegiatan, dan seluruh aspek administrasi sistem.' }}</p>
                        <a href="{{ route('admin.login') }}" class="inline-block px-6 py-3 bg-secondary-600 hover:bg-secondary-700 text-white rounded-lg font-semibold transition duration-300">
                            <i class="fas fa-shield-alt mr-2"></i> {{ $sections['login']['admin_button'] ?? 'Login Admin' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer dengan Tailwind -->
    <footer class="bg-gray-900 text-gray-100">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h5 class="text-xl font-semibold mb-4 flex items-center">
                        <i class="fas fa-building mr-2"></i> {{ $sections['footer']['title'] ?? 'Pitaloka AMS' }}
                    </h5>
                    <p class="text-gray-400 mb-6">{{ $sections['footer']['description'] ?? 'Sistem manajemen anggota modern untuk pendaftaran, pengelolaan kegiatan, dan administrasi keanggotaan yang efisien dan terpadu.' }}</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="{{ $sections['footer']['facebook_url'] ?? '#' }}" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="{{ $sections['footer']['twitter_url'] ?? '#' }}" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="{{ $sections['footer']['instagram_url'] ?? '#' }}" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="{{ $sections['footer']['linkedin_url'] ?? '#' }}" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h5 class="text-xl font-semibold mb-4">Menu</h5>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('welcome') }}" class="text-gray-400 hover:text-white transition duration-300">Beranda</a>
                        </li>
                        <li>
                            <a href="#about-section" class="text-gray-400 hover:text-white transition duration-300">Tentang Kami</a>
                        </li>
                        <li>
                            <a href="#gallery-section" class="text-gray-400 hover:text-white transition duration-300">Galeri</a>
                        </li>
                        <li>
                            <a href="{{ route('anggota.daftar') }}" class="text-gray-400 hover:text-white transition duration-300">Pendaftaran</a>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h5 class="text-xl font-semibold mb-4">Akses Cepat</h5>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition duration-300">Login Anggota</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.login') }}" class="text-gray-400 hover:text-white transition duration-300">Login Admin</a>
                        </li>
                        <li>
                            <a href="{{ route('anggota.daftar') }}" class="text-gray-400 hover:text-white transition duration-300">Daftar Anggota</a>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h5 class="text-xl font-semibold mb-4">Kontak</h5>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-gray-500"></i>
                            <span class="text-gray-400">Jl. Contoh No. 123, Jakarta</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-gray-500"></i>
                            <span class="text-gray-400">info@pitalokaams.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-gray-500"></i>
                            <span class="text-gray-400">(021) 1234-5678</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 mt-8 border-t border-gray-800 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Pitaloka AMS - Sistem Manajemen Anggota. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript for District Pie Chart -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch district data and member counts
            fetch('/api/district-statistics')
                .then(response => response.json())
                .then(data => {
                    createDistrictChart(data);
                })
                .catch(error => {
                    console.error('Error fetching district data:', error);
                    // Fallback with sample data if API fails
                    createDistrictChart([
                        { name: 'Jakarta Selatan', count: 120 },
                        { name: 'Jakarta Pusat', count: 85 },
                        { name: 'Jakarta Timur', count: 64 },
                        { name: 'Jakarta Barat', count: 53 },
                        { name: 'Jakarta Utara', count: 41 },
                        { name: 'Kepulauan Seribu', count: 12 }
                    ]);
                });
            
            function createDistrictChart(data) {
                const ctx = document.getElementById('districtChart').getContext('2d');
                
                // Generate colors array - using our purple/yellow color scheme
                const purpleColors = [
                    '#581c87', // primary-900
                    '#6b21a8', // primary-800
                    '#7e22ce', // primary-700
                    '#9333ea', // primary-600
                    '#a855f7', // primary-500
                    '#c084fc', // primary-400
                ];
                
                const yellowColors = [
                    '#ca8a04', // secondary-600
                    '#eab308', // secondary-500
                    '#facc15', // secondary-400
                ];
                
                const finalColors = [...purpleColors, ...yellowColors];
                const colors = [];
                
                for (let i = 0; i < data.length; i++) {
                    colors.push(finalColors[i % finalColors.length]);
                }
                
                // Create chart
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.map(item => item.name),
                        datasets: [{
                            data: data.map(item => item.count),
                            backgroundColor: colors,
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    font: {
                                        family: 'Poppins',
                                        size: 13
                                    },
                                    padding: 15
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} anggota (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>