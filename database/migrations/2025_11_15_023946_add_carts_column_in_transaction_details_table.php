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
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id')->after('transaction_detail_id');
            
            $table->index('cart_id');

            $table->foreign('cart_id')
                ->references('cart_id')
                ->on('carts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropIndex(['cart_id']);
            $table->dropColumn('cart_id');
        });
    }
};
