<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groomers', function (Blueprint $table) {
            // PK: groomer_id
            $table->bigIncrements('groomer_id');

            // FK: user_id (merujuk ke tabel 'users')
            $table->unsignedBigInteger('user_id')->unique(); // Unique untuk relasi One-to-One
            
            // Kolom Lain
            $table->unsignedInteger('total_appointments_completed')->default(0);
            $table->unsignedInteger('total_minutes_worked')->default(0);

            // Timestamps
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groomers');
    }
}