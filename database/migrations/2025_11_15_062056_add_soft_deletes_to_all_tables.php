<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    protected $tables = [
        'appointment_details',
        'appointments',
        'cache',
        'cache_locks',
        'carts',
        'couriers',
        'deliveries',
        'failed_jobs',
        'groomers',
        'job_batches',
        'jobs',
        'migrations',
        'password_reset_tokens',
        'payments',
        'pets',
        'products',
        'refund_details',
        'refund_headers',
        'reviews',
        'services',
        'sessions',
        'suppliers',
        'transaction_details',
        'transactions',
        'users',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            // skip tabel yang ga butuh soft delete
            if (in_array($tableName, ['migrations', 'failed_jobs', 'jobs', 'job_batches', 'cache', 'cache_locks', 'sessions', 'password_reset_tokens'])) {
                continue;
            }

            if (Schema::hasTable($tableName) && ! Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->softDeletes(); // nambahin deleted_at nullable
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (in_array($tableName, ['migrations', 'failed_jobs', 'jobs', 'job_batches', 'cache', 'cache_locks', 'sessions', 'password_reset_tokens'])) {
                continue;
            }

            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        }
    }
};
