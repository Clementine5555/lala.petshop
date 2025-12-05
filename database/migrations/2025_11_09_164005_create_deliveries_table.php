<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    public function up()
    {
        // Skip if table already exists
        if (Schema::hasTable('deliveries')) {
            return;
        }

        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('delivery_id');
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->text('address')->nullable();
            $table->string('status', 50)->nullable();
            $table->text('description')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('courier_id');
            $table->index('transaction_id');

            $table->foreign('courier_id')
                ->references('user_id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('transaction_id')
                ->references('transaction_id')
                ->on('transactions')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropForeign(['courier_id']);
            $table->dropForeign(['transaction_id']);
        });
        Schema::dropIfExists('deliveries');
    }
}
