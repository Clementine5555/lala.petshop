<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            if (!Schema::hasColumn('pets', 'photo')) {
                $table->string('photo')->nullable()->after('weight');
            }
            if (!Schema::hasColumn('pets', 'description')) {
                $table->text('description')->nullable()->after('photo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            if (Schema::hasColumn('pets', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('pets', 'photo')) {
                $table->dropColumn('photo');
            }
        });
    }
};
