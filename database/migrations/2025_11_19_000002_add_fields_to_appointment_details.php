<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            if (!Schema::hasColumn('appointment_details', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('appointment_detail_id');
            }
            if (!Schema::hasColumn('appointment_details', 'groomer_id')) {
                $table->unsignedBigInteger('groomer_id')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('appointment_details', 'status')) {
                $table->string('status', 50)->nullable()->after('time');
            }
            if (!Schema::hasColumn('appointment_details', 'total_appointments_completed')) {
                $table->integer('total_appointments_completed')->default(0)->after('status');
            }

            // add indexes and foreign keys
            $table->index('user_id');
            $table->index('groomer_id');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('groomer_id')
                ->references('groomer_id')
                ->on('groomers')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('appointment_details', function (Blueprint $table) {
            if (Schema::hasColumn('appointment_details', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('appointment_details', 'groomer_id')) {
                $table->dropForeign(['groomer_id']);
                $table->dropColumn('groomer_id');
            }
            if (Schema::hasColumn('appointment_details', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('appointment_details', 'total_appointments_completed')) {
                $table->dropColumn('total_appointments_completed');
            }
        });
    }
};
