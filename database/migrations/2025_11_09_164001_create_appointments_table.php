<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('appointment_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->dateTime('appointment_date')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('payment_id');
            $table->foreign('payment_id')
                ->references('payment_id')
                ->on('payments')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign([ 'payment_id' ]);
        });
        Schema::dropIfExists('appointments');
    }
}
