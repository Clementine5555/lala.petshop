<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('appointment_details', function (Blueprint $table) {
            $table->bigIncrements('appointment_detail_id');
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('pet_id');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->text('note')->nullable();

            $table->index('appointment_id');
            $table->index('service_id');
            $table->index('pet_id');

            $table->foreign('appointment_id')
                ->references('appointment_id')
                ->on('appointments')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('service_id')
                ->references('service_id')
                ->on('services')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('pet_id')
                ->references('pet_id')
                ->on('pets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['pet_id']);
        });
        Schema::dropIfExists('appointment_details');
    }
}
