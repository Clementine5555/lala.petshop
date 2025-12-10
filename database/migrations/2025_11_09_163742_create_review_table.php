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
        if (!Schema::hasTable('reviews')) {

            Schema::create('reviews', function (Blueprint $table) {
                $table->bigIncrements('review_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('rating');
                $table->text('comment')->nullable();
                $table->dateTime('date')->nullable();
                $table->timestamps();

                $table->index('user_id');
                $table->index('product_id');

                $table->foreign('user_id')
                    ->references('user_id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('product_id')
                    ->references('product_id')
                    ->on('products')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('reviews')) {
            Schema::table('reviews', function (Blueprint $table) {
                // Hapus Foreign Key dulu (praktik yang aman)
                $table->dropForeign(['user_id']);
                $table->dropForeign(['product_id']);
            });

            Schema::dropIfExists('reviews');
        }
    }
};
