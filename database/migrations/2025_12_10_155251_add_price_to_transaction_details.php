<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Pastikan nama tabelnya 'transaction_details' (jamak) sesuai error kamu
        Schema::table('transaction_details', function (Blueprint $table) {

            // Tambah kolom PRICE
            if (!Schema::hasColumn('transaction_details', 'price')) {
                $table->integer('price')->default(0)->after('product_id');
            }

            // Tambah kolom QUANTITY (Jaga-jaga kalau belum ada juga)
            if (!Schema::hasColumn('transaction_details', 'quantity')) {
                $table->integer('quantity')->default(1)->after('price');
            }
        });
    }

    public function down()
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn(['price', 'quantity']);
        });
    }
};
