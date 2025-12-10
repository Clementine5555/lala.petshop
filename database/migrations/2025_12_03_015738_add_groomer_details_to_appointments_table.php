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
        Schema::table('appointments', function (Blueprint $table) {
            // Kita tambahkan kolom yang dibutuhkan Groomer Dashboard
            // Kita taruh setelah kolom 'status' biar rapi

            $table->string('customer_name')->nullable()->after('status'); // Nama pemilik
            $table->string('pet_name')->nullable()->after('customer_name');
            $table->string('pet_type')->nullable()->after('pet_name'); // Kucing/Anjing
            $table->string('pet_gender')->nullable()->after('pet_type');
            $table->string('pet_weight')->nullable()->after('pet_gender');

            $table->string('service_type')->nullable()->after('pet_weight'); // Full Grooming/Bath Only
            $table->text('notes')->nullable()->after('service_type');

            // Kolom untuk tracking pengerjaan
            $table->timestamp('completed_at')->nullable()->after('updated_at');
            $table->string('duration')->nullable()->after('completed_at');
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'pet_name',
                'pet_type',
                'pet_gender',
                'pet_weight',
                'service_type',
                'notes',
                'completed_at',
                'duration'
            ]);
        });
    }
};
