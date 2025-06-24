<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menggunakan DB::statement untuk mengubah kolom dengan default value
        DB::statement('ALTER TABLE activity_proposals MODIFY budget_amount DECIMAL(12,2) NOT NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan kolom ke kondisi sebelumnya
        DB::statement('ALTER TABLE activity_proposals MODIFY budget_amount DECIMAL(12,2) NOT NULL');
    }
};
