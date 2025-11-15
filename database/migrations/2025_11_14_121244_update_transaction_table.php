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
        Schema::table('transactions', function (Blueprint $table) {
            // Harus dihapus dulu sebelum mengubah properti kolom (nullable/tipe).
            $table->dropForeign(['user_id']);
            $table->dropForeign(['payment_id']);

            $table->dropColumn('transaction_date');
            //// Ubah Kolom user_id dan payment_id menjadi TIDAK NULLABLE
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->unsignedBigInteger('payment_id')->nullable(false)->change();

            // Tambah Kolom delivery_method
            $table->enum('delivery_method', ['pickup', 'delivery'])
                  ->default('delivery')
                  ->after('payment_id');

            $table->enum('status', [ 
                'processing', 
                'waiting_for_payment',
                'ready_for_pickup', 
                'completed', 
                'cancelled',
            ])
            ->default('processing')
            ->after('delivery_method');

            // Tambahkan Foreign Keys Baru (onDelete: cascade karena non-nullable)
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade'); 

            $table->foreign('payment_id')
                ->references('payment_id')
                ->on('payments')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Hapus kolom created_at dan updated_at yang mungkin dibuat secara manual
             $table->dropColumn(['created_at', 'updated_at']);
        
             // Tambahkan kembali created_at dan updated_at sesuai konvensi Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop Foreign Keys Baru 
            $table->dropForeign(['user_id']);
            $table->dropForeign(['payment_id']);
            
            // Hapus Kolom Baru 
            $table->dropColumn(['delivery_method', 'status']);

            // Kembalikan ke Struktur Awal (Nullable)              
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('payment_id')->nullable()->change();
            
            // Kembalikan transaction_date
            $table->dateTime('transaction_date')->nullable()->after('payment_id');

            // Kembalikan Foreign Keys Lama (onDelete: set null) 
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('payment_id')
                ->references('payment_id')
                ->on('payments')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Hapus timestamps()
            $table->dropTimestamps(); 
            
            // Kembalikan kolom created_at dan updated_at ke bentuk sebelumnya 
            // (Asumsi bentuk sebelumnya adalah $table->timestamp() manual dan nullable)
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        
        });
    }
};
