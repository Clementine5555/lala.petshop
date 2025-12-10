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
            // Kolom untuk menyimpan nama file bukti bayar
            if (!Schema::hasColumn('transactions', 'proof_of_payment')) {
                $table->string('proof_of_payment')->nullable()->after('total_price');
            }
            // Kolom untuk menyimpan metode pembayaran (cash, transfer, e-wallet)
            if (!Schema::hasColumn('transactions', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('status');
            }
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['proof_of_payment', 'payment_method']);
        });
    }
};
