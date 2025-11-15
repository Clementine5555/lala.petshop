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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->text('address')->nullable(false)->change();
            $table->string('email', 150)->nullable(false)->change();
            $table->string('phone_number', 50)->nullable(false)->change();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->text('address')->nullable()->change();
            $table->string('email', 150)->nullable()->change();
            $table->string('phone_number', 50)->nullable()->change();
        });
    }
};
