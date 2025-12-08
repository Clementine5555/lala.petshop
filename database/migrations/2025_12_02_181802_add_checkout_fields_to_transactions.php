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
        $tableName = 'transactions';

        // Add columns only if they don't already exist (prevents duplicate column errors)
        if (! Schema::hasColumn($tableName, 'receiver_name') ||
            ! Schema::hasColumn($tableName, 'receiver_address') ||
            ! Schema::hasColumn($tableName, 'receiver_phone') ||
            ! Schema::hasColumn($tableName, 'total_price') ||
            ! Schema::hasColumn($tableName, 'status')) {

            Schema::table($tableName, function (Blueprint $table) {
                if (! Schema::hasColumn('transactions', 'receiver_name')) {
                    $table->string('receiver_name')->nullable();
                }
                if (! Schema::hasColumn('transactions', 'receiver_address')) {
                    $table->text('receiver_address')->nullable();
                }
                if (! Schema::hasColumn('transactions', 'receiver_phone')) {
                    $table->string('receiver_phone', 20)->nullable();
                }

                if (! Schema::hasColumn('transactions', 'total_price')) {
                    $table->integer('total_price')->default(0);
                }
                if (! Schema::hasColumn('transactions', 'status')) {
                    $table->string('status')->default('pending');
                }
            });
        }
    }

    public function down()
    {
        $tableName = 'transactions';

        Schema::table($tableName, function (Blueprint $table) {
            $drop = [];
            if (Schema::hasColumn($tableName, 'receiver_name')) $drop[] = 'receiver_name';
            if (Schema::hasColumn($tableName, 'receiver_address')) $drop[] = 'receiver_address';
            if (Schema::hasColumn($tableName, 'receiver_phone')) $drop[] = 'receiver_phone';
            if (Schema::hasColumn($tableName, 'total_price')) $drop[] = 'total_price';
            if (Schema::hasColumn($tableName, 'status')) $drop[] = 'status';

            if (! empty($drop)) {
                $table->dropColumn($drop);
            }
        });
    }
};
