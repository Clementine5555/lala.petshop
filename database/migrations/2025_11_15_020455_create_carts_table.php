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
        Schema::create('carts', function (Blueprint $table) {
           $table->bigIncrements('cart_id');
            // Kolom untuk menghubungkan keranjang ke pengguna
           $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');

           // FK: product_id
            $table->foreignId('product_id')->constrained('products', 'product_id')->onDelete('cascade')->onUpdate('cascade');
            
            // Kolom Data: quantity
            $table->unsignedInteger('quantity')->default(1);
            
            // Kolom Status: status (active, converted)
            $table->enum('status', ['active', 'converted'])->default('active');
            
            $table->timestamps();
            
            // Index unik untuk memastikan satu produk hanya ada sekali 
            // di keranjang yang sama milik satu pengguna (saat statusnya 'active').
            // Ini mencegah duplikasi baris.
            $table->unique(['user_id', 'product_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
