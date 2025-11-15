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
        Schema::table('appointments', function (Blueprint $table) {
            
            // Hapus Foreign Key lama
            $table->dropForeign(['payment_id']);
            
            // Hapus kolom lama/yang diubah:
            $table->dropColumn(['payment_id', 'appointment_date', 'status', 'created_at', 'updated_at']);
        });

        Schema::table('appointments', function (Blueprint $table) {

            // payment_id (Tidak Nullable + Foreign Key)
            $table->unsignedBigInteger('payment_id')->after('appointment_id');
            $table->foreign('payment_id')
                ->references('payment_id')
                ->on('payments')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // Otomatis membuat indeks
            
            // status (ENUM, Default 'pending', Tidak Nullable)
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
                  ->default('pending')
                  ->after('payment_id');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropTimestamps();
            $table->dropColumn(['payment_id', 'status']);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_id')->nullable()->after('appointment_id');
            $table->foreign('payment_id')
                ->references('payment_id')
                ->on('payments')
                ->onUpdate('cascade')
                ->onDelete('set null');
            
            $table->dateTime('appointment_date')->nullable()->after('payment_id');

            $table->string('status', 50)->nullable()->after('appointment_date');
            
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            
            $table->index('payment_id');
        });
    }
};