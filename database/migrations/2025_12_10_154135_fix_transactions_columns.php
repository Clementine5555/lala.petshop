<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Kita cek satu-satu biar aman, kalau belum ada baru dibuat

            if (!Schema::hasColumn('transactions', 'status')) {
                $table->string('status')->default('pending')->after('payment_id');
            }

            if (!Schema::hasColumn('transactions', 'total_price')) {
                $table->decimal('total_price', 15, 2)->default(0)->after('status');
            }

            if (!Schema::hasColumn('transactions', 'receiver_name')) {
                $table->string('receiver_name')->nullable()->after('total_price');
            }

            if (!Schema::hasColumn('transactions', 'receiver_address')) {
                $table->text('receiver_address')->nullable()->after('receiver_name');
            }

            if (!Schema::hasColumn('transactions', 'receiver_phone')) {
                $table->string('receiver_phone')->nullable()->after('receiver_address');
            }
        });
    }

    public function down()
    {
        // Opsional: Drop column jika rollback
    }
};
