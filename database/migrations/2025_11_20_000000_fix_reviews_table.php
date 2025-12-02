<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Idempotent: only adds missing columns (no foreign keys).
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('reviews')) {
            // Nothing to fix if table doesn't exist
            return;
        }

        // Add rating if missing
        if (!Schema::hasColumn('reviews', 'rating')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->integer('rating')->default(0)->after('product_id');
            });
        }

        // Add comment if missing
        if (!Schema::hasColumn('reviews', 'comment')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->text('comment')->nullable()->after('rating');
            });
        }

        // Add created_at/updated_at timestamps if missing
        $hasCreated = Schema::hasColumn('reviews', 'created_at');
        $hasUpdated = Schema::hasColumn('reviews', 'updated_at');

        if (!($hasCreated && $hasUpdated)) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->timestamps();
            });
        }

        // Ensure user_id exists (but avoid adding FKs here to prevent cross-table FK issues)
        if (!Schema::hasColumn('reviews', 'user_id')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('review_id');
            });
        }

        // Ensure product_id exists
        if (!Schema::hasColumn('reviews', 'product_id')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->unsignedBigInteger('product_id')->nullable()->after('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     * We won't drop columns here to avoid accidental data loss.
     *
     * @return void
     */
    public function down()
    {
        // Intentionally empty — keep data intact. If you need to revert, do it manually.
    }
};
