<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('referral_commission_rate', 5, 2)->default(10.00)
                ->after('id')
                ->comment('Percentage bonus awarded to referrer on wallet top-ups, e.g. 10.00 = 10%');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('referral_commission_rate');
        });
    }
};
