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
        if (Schema::hasTable('support_tickets') && !Schema::hasColumn('support_tickets', 'reference')) {
            Schema::table('support_tickets', function (Blueprint $table) {
                $table->string('reference', 20)->nullable()->index()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('support_tickets') && Schema::hasColumn('support_tickets', 'reference')) {
            Schema::table('support_tickets', function (Blueprint $table) {
                $table->dropColumn('reference');
            });
        }
    }
};

