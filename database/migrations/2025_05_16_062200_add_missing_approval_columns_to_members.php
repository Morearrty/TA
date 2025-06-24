<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('members', 'approval_status')) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            }
            
            if (!Schema::hasColumn('members', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('members', 'approval_notes')) {
                $table->text('approval_notes')->nullable();
            }
            
            if (!Schema::hasColumn('members', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop columns if they exist
            $columns = ['approval_status', 'approval_notes', 'approved_at'];
            
            // Drop foreign key first
            if (Schema::hasColumn('members', 'approved_by')) {
                $table->dropForeign(['approved_by']);
                $table->dropColumn('approved_by');
            }
            
            // Drop the rest of the columns
            foreach ($columns as $column) {
                if (Schema::hasColumn('members', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
