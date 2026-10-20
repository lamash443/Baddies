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
        Schema::table('visitors', function (Blueprint $table) {
            if (!Schema::hasColumn('visitors', 'country')) {
                $table->string('country')->nullable()->after('ip_address')->index();
            }
            if (!Schema::hasColumn('visitors', 'country_code')) {
                $table->string('country_code', 10)->nullable()->after('country')->index();
            }
            if (!Schema::hasColumn('visitors', 'city')) {
                $table->string('city')->nullable()->after('country_code');
            }
            if (!Schema::hasColumn('visitors', 'region')) {
                $table->string('region')->nullable()->after('city');
            }
            if (!Schema::hasColumn('visitors', 'total_time_seconds')) {
                $table->unsignedBigInteger('total_time_seconds')->default(0)->after('visits_count');
            }
            if (!Schema::hasColumn('visitors', 'first_visit_at')) {
                $table->timestamp('first_visit_at')->nullable()->after('user_agent');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach (['country', 'country_code', 'city', 'region', 'total_time_seconds', 'first_visit_at'] as $column) {
                if (Schema::hasColumn('visitors', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
