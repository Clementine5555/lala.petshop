<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tambah kolom gambar ke services
        Schema::table('services', function (Blueprint $table) {
            $table->string('image')->nullable()->after('service_name'); 
        });

        // Tambah kolom gambar ke products
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')->nullable()->after('name');
        });

        // Tambah kolom evidence ke deliveries
        Schema::table('deliveries', function (Blueprint $table) {
            $table->string('evidence')->nullable()->after('status'); 
        });
    }

    public function down()
    {
        // Hapus kolom jika rollback
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn('evidence');
        });
    }
};
