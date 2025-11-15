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
        Schema::table('refund_headers', function (Blueprint $table) {
            // Ubah kolom status_refund menjadi ENUM
            $table->enum('status_refund', [
                'reviewing',
                'approved',
                'rejected',
                'refunded',
            ])->default('reviewing')->change();
           });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refund_headers', function (Blueprint $table) {
            // Balikin status_refund jadi string
            $table->string('status_refund', 50)->nullable()->change();
        });
    }
};
