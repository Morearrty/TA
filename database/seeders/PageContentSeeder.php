<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hero Section
        $this->createPageContent('hero', 'title', 'Pitaloka AMS', 'text');
        $this->createPageContent('hero', 'subtitle', 'Sistem manajemen anggota modern untuk pendaftaran, pengelolaan kegiatan, dan administrasi keanggotaan yang efisien dan terpadu', 'textarea');
        $this->createPageContent('hero', 'register_button_text', 'Daftar Menjadi Anggota', 'text');
        $this->createPageContent('hero', 'login_button_text', 'Login Anggota', 'text');
        
        // About Section
        $this->createPageContent('about', 'title', 'Tentang Pitaloka AMS', 'text');
        $this->createPageContent('about', 'description', 'Pitaloka Association Management System (AMS) adalah sistem manajemen anggota yang dirancang untuk memudahkan proses pendaftaran, pengelolaan, dan administrasi anggota organisasi.', 'textarea');
        
        $this->createPageContent('about', 'vision_title', 'Visi', 'text');
        $this->createPageContent('about', 'vision_description', 'Menjadi sistem manajemen anggota terdepan yang memudahkan organisasi dalam mengelola anggota dan meningkatkan efisiensi administrasi keanggotaan di berbagai jenis organisasi.', 'textarea');
        
        $this->createPageContent('about', 'mission_title', 'Misi', 'text');
        $this->createPageContent('about', 'mission_description', 'Membangun platform yang mudah digunakan dan komprehensif untuk mendukung pengelolaan anggota, mengotomatisasi proses administratif, dan memfasilitasi komunikasi antar anggota organisasi.', 'textarea');
        
        $this->createPageContent('about', 'feature1_title', 'Pendaftaran Anggota', 'text');
        $this->createPageContent('about', 'feature1_description', 'Proses pendaftaran yang mudah dan cepat dengan pembuatan Kartu Tanda Anggota (KTA) otomatis yang dapat diunduh dan dicetak.', 'textarea');
        
        $this->createPageContent('about', 'feature2_title', 'Manajemen Distrik', 'text');
        $this->createPageContent('about', 'feature2_description', 'Pengelolaan anggota berdasarkan distrik atau cabang wilayah untuk memudahkan koordinasi dan pengorganisasian kegiatan.', 'textarea');
        
        $this->createPageContent('about', 'feature3_title', 'Pengajuan Kegiatan', 'text');
        $this->createPageContent('about', 'feature3_description', 'Sistem pengajuan kegiatan dan anggaran yang transparan dan efisien untuk mendukung aktivitas organisasi di setiap distrik.', 'textarea');
        
        // Statistics Section
        $this->createPageContent('stats', 'title', 'Statistik Keanggotaan', 'text');
        $this->createPageContent('stats', 'description', 'Perkembangan jumlah anggota dan distrik dalam Pitaloka AMS', 'textarea');
        $this->createPageContent('stats', 'members_label', 'Anggota Aktif', 'text');
        $this->createPageContent('stats', 'districts_label', 'Distrik Terdaftar', 'text');
        
        // Gallery Section
        $this->createPageContent('gallery', 'title', 'Galeri Kegiatan', 'text');
        $this->createPageContent('gallery', 'description', 'Dokumentasi kegiatan-kegiatan yang telah dilaksanakan oleh anggota organisasi', 'textarea');
        
        $this->createPageContent('gallery', 'main_image', 'https://source.unsplash.com/random/1200x600/?conference', 'image');
        $this->createPageContent('gallery', 'main_title', 'Konferensi Tahunan', 'text');
        $this->createPageContent('gallery', 'main_description', 'Pertemuan anggota dalam konferensi tahunan organisasi untuk mendiskusikan perkembangan dan rencana ke depan', 'textarea');
        
        // CTA Section
        $this->createPageContent('cta', 'title', 'Bergabunglah Bersama Kami', 'text');
        $this->createPageContent('cta', 'description', 'Menjadi bagian dari jaringan anggota kami dan dapatkan berbagai manfaat keanggotaan', 'textarea');
        $this->createPageContent('cta', 'button_text', 'Daftar Sekarang', 'text');
        
        // Login Section
        $this->createPageContent('login', 'title', 'Akses Sistem', 'text');
        $this->createPageContent('login', 'description', 'Login ke sistem sesuai peran Anda', 'textarea');
        
        $this->createPageContent('login', 'member_title', 'Anggota', 'text');
        $this->createPageContent('login', 'member_description', 'Akses dashboard anggota untuk melihat informasi keanggotaan, mengunduh KTA, dan mengakses fitur anggota lainnya.', 'textarea');
        $this->createPageContent('login', 'member_button', 'Login Anggota', 'text');
        
        $this->createPageContent('login', 'admin_title', 'Administrator', 'text');
        $this->createPageContent('login', 'admin_description', 'Akses dashboard admin untuk mengelola anggota, distrik, kegiatan, dan seluruh aspek administrasi sistem.', 'textarea');
        $this->createPageContent('login', 'admin_button', 'Login Admin', 'text');
        
        // Footer
        $this->createPageContent('footer', 'about_description', 'Sistem manajemen anggota modern untuk pendaftaran, pengelolaan kegiatan, dan administrasi keanggotaan yang efisien dan terpadu.', 'textarea');
        $this->createPageContent('footer', 'address', 'Jl. Contoh No. 123, Jakarta', 'text');
        $this->createPageContent('footer', 'email', 'info@pitalokaams.com', 'text');
        $this->createPageContent('footer', 'phone', '(021) 1234-5678', 'text');
        $this->createPageContent('footer', 'copyright', 'Pitaloka AMS - Sistem Manajemen Anggota. All rights reserved.', 'text');
    }
    
    /**
     * Create a page content record
     *
     * @param string $section
     * @param string $key
     * @param string $value
     * @param string $type
     * @param int $sortOrder
     * @return void
     */
    private function createPageContent(string $section, string $key, string $value, string $type, int $sortOrder = 0): void
    {
        PageContent::updateOrCreate(
            ['section' => $section, 'key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'is_active' => true,
                'sort_order' => $sortOrder
            ]
        );
    }
}
