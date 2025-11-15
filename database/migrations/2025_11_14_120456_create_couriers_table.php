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
        Schema::create('couriers', function (Blueprint $table) {
            $table->bigIncrements('courier_id');
            $table->unsignedBigInteger('user_id')->unique(); // Unique karena satu user hanya bisa jadi satu kurir
            $table->integer('total_deliveries_completed')->default(0);
            $table->float('total_distance_km')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('couriers', function (Blueprint $table) {
            // Drop Foreign Key sebelum menghapus tabel
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('couriers');
    }
};
