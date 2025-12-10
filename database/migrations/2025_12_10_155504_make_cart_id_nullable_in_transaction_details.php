<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Kita ubah kolom cart_id agar boleh NULL (kosong)
        // Perintah ini akan mengubah struktur kolom secara langsung
        try {
            DB::statement("ALTER TABLE transaction_details MODIFY cart_id BIGINT UNSIGNED NULL");
        } catch (\Exception $e) {
            // Jika error (misal tipe datanya beda), kita coba cara standar Laravel
            Schema::table('transaction_details', function (Blueprint $table) {
                // Perlu doctrine/dbal terinstall untuk jalanin baris ini,
                // makanya kita taruh di catch sebagai cadangan
                $table->unsignedBigInteger('cart_id')->nullable()->change();
            });
        }
    }

    public function down()
    {
        // Opsional: Kembalikan ke tidak boleh null
    }
};
