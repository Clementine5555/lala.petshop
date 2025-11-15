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
        Schema::table('deliveries', function (Blueprint $table) {
            // Drop foreign key lama
            $table->dropForeign(['courier_id']);
  
            // Update status jadi ENUM
            $table->enum('status', ['pending', 'shipped', 'delivered', 'returned'])
                  ->nullable()
                  ->change();

            // Bikin ulang foreign key sesuai ERD
            $table->foreign('courier_id')
                  ->references('courier_id')
                  ->on('couriers')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            // Drop fk baru
            $table->dropForeign(['courier_id']);
            
            // Revert status ke string
            $table->string('status', 50)->nullable()->change();

            // Balikin fk lama (users)
            $table->foreign('courier_id')
                  ->references('user_id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }
};
