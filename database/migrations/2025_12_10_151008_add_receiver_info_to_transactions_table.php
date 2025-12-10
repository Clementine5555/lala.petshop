<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {

            // Cek total_price (biasanya sudah ada, tapi kita cek biar aman)
            if (!Schema::hasColumn('transactions', 'total_price')) {
                $table->decimal('total_price', 15, 2)->default(0)->after('status');
            }

            // Cek receiver_name
            if (!Schema::hasColumn('transactions', 'receiver_name')) {
                $table->string('receiver_name')->nullable()->after('status');
            }

            // Cek receiver_address
            if (!Schema::hasColumn('transactions', 'receiver_address')) {
                $table->text('receiver_address')->nullable()->after('receiver_name');
            }

            // Cek receiver_phone
            if (!Schema::hasColumn('transactions', 'receiver_phone')) {
                $table->string('receiver_phone')->nullable()->after('receiver_address');
            }
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['receiver_name', 'receiver_address', 'receiver_phone']);
        });
    }
};
