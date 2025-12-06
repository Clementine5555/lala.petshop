<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('receiver_name')->nullable();
            $table->text('receiver_address')->nullable();
            $table->string('receiver_phone', 20)->nullable();

            $table->integer('total_price')->default(0);
            $table->string('status')->default('pending');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'receiver_name',
                'receiver_address',
                'receiver_phone',
                'total_price',
                'status'
            ]);
        });
    }
};
