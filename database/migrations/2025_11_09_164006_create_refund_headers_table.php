<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundHeadersTable extends Migration
{
    public function up()
    {
        Schema::create('refund_headers', function (Blueprint $table) {
            $table->bigIncrements('refund_id');
            $table->unsignedBigInteger('transaction_id');
            $table->dateTime('date')->nullable();
            $table->text('reason')->nullable();
            $table->string('status_refund', 50)->nullable();

            $table->index('transaction_id');

            $table->foreign('transaction_id')
                ->references('transaction_id')
                ->on('transactions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('refund_headers', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
        });
        Schema::dropIfExists('refund_headers');
    }
}
