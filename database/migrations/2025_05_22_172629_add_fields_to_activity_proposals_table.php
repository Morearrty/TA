<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\Type;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activity_proposals', function (Blueprint $table) {
            // Untuk menggunakan metode change(), perlu aktifkan terlebih dahulu DBAL
            // Tetapi karena mungkin belum diinstal, kita gunakan alternatif
        
            // Tambahkan kolom-kolom baru
            $table->string('target_participants')->nullable()->after('location');
            $table->text('attachments')->nullable()->after('budget_details');
            $table->foreignId('created_by')->nullable()->after('approved_by')->constrained('users')->onDelete('set null');
            $table->timestamp('submitted_at')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_proposals', function (Blueprint $table) {
            $table->dropColumn('target_participants');
            $table->dropColumn('attachments');
            $table->dropColumn('created_by');
            $table->dropColumn('submitted_at');
        });
    }
};
