<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('refund_details', function (Blueprint $table) {
            $table->bigIncrements('refund_detail_id');
            $table->unsignedBigInteger('refund_id');
            $table->unsignedBigInteger('transaction_detail_id');
            $table->integer('quantity')->default(1);

            $table->index('refund_id');
            $table->index('transaction_detail_id');

            $table->foreign('refund_id')
                ->references('refund_id')
                ->on('refund_headers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('transaction_detail_id')
                ->references('transaction_detail_id')
                ->on('transaction_details')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('refund_details', function (Blueprint $table) {
            $table->dropForeign(['refund_id']);
            $table->dropForeign(['transaction_detail_id']);
        });
        Schema::dropIfExists('refund_details');
    }
}
