<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('groomers')) {

            Schema::create('groomers', function (Blueprint $table) {
                $table->bigIncrements('groomer_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('phone_number')->nullable();
                $table->text('address')->nullable();
                $table->integer('total_appointments_completed')->default(0);
                $table->integer('total_hours_worked')->default(0);
                $table->timestamps();

                $table->index('user_id');

                // Foreign Key definition
                $table->foreign('user_id')
                    ->references('user_id')
                    ->on('users')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('groomers')) {
            Schema::table('groomers', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
            Schema::dropIfExists('groomers');
        }
    }
};
