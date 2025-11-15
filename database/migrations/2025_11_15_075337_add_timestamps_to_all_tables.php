<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $tableObj) {
            $table = array_values((array)$tableObj)[0];

            // Skip tabel yang gak usah ditambahin
            if (in_array($table, ['migrations'])) {
                continue;
            }

            Schema::table($table, function (Blueprint $tableBlueprint) use ($table) {
                if (!Schema::hasColumn($table, 'created_at') &&
                    !Schema::hasColumn($table, 'updated_at')) {

                    $tableBlueprint->timestamps();
                }
            });
        }
    }

    public function down()
    {
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $tableObj) {
            $table = array_values((array)$tableObj)[0];

            if (in_array($table, ['migrations'])) {
                continue;
            }

            Schema::table($table, function (Blueprint $tableBlueprint) use ($table) {
                if (Schema::hasColumn($table, 'created_at')) {
                    $tableBlueprint->dropColumn('created_at');
                }
                if (Schema::hasColumn($table, 'updated_at')) {
                    $tableBlueprint->dropColumn('updated_at');
                }
            });
        }
    }
};
