<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    public function up()
    {
        // Skip if table already exists
        if (Schema::hasTable('transaction_details')) {
            return;
        }

        Schema::create('transaction_details', function (Blueprint $table) {
            $table->bigIncrements('transaction_detail_id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->decimal('price_at_purchase', 12, 2)->default(0.00);

            $table->index('transaction_id');
            $table->index('product_id');

            $table->foreign('transaction_id')
                ->references('transaction_id')
                ->on('transactions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('transaction_details');
    }
}
