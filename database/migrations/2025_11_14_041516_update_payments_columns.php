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
        Schema::table('payments', function (Blueprint $table) {

            // Ubah method jadi ENUM
            $table->enum('method', [
                'cash',
                'bank_transfer',
                'ewallet',
            ])->default('cash')->change();

            // Ubah kolom status jadi ENUM
            $table->enum('status', [
                'pending',
                'success',
                'failed',
                'cancelled',
            ])->default('pending')->change();

            // Ubah kolom evidence jadi NOT NULL
            $table->string('evidence')->nullable(false)->change();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('method')->nullable()->change();
            $table->string('status')->default('pending')->change();
            $table->string('evidence')->nullable()->change();
        });
    }
};
