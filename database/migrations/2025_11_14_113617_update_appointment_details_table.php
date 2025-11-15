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
        Schema::table('appointment_details', function (Blueprint $table) {
            
            /// Tambah groomer_id sebagai kolom kedua setelah appointment_id
            $table->unsignedBigInteger('groomer_id')->after('appointment_id');
            
            // Tambahkan Index dan Foreign Key
            $table->index('groomer_id');
            $table->foreign('groomer_id')
                ->references('groomer_id')
                ->on('groomers')
                ->onUpdate('cascade')
                ->onDelete('restrict'); // Gunakan restrict agar detail tidak bisa dihapus jika masih ada groomer yang merujuk
            
            // --- Ubah Kolom date dan time menjadi TIDAK NULLABLE ---
            $table->date('date')->nullable(false)->change();
            $table->time('time')->nullable(false)->change();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            $table->dropForeign(['groomer_id']);
            $table->dropIndex(['groomer_id']);
            $table->dropColumn('groomer_id');
            $table->date('date')->nullable()->change();
            $table->time('time')->nullable()->change();

            $table->dropTimestamps();
        });
    }
};