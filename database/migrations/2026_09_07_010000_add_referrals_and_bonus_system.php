<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add referral columns to the users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('referral_code', 12)->nullable()->unique()->after('wallet_balance');
            $table->foreignId('referred_by_id')->nullable()->constrained('users')->nullOnDelete()->after('referral_code');
            $table->decimal('referral_balance', 10, 2)->default(0.00)->after('referred_by_id');
            $table->decimal('total_referral_earnings', 10, 2)->default(0.00)->after('referral_balance');
        });

        // 2. Create the referral_earnings table
        Schema::create('referral_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('referee_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('deposit_id')->constrained('deposits')->cascadeOnDelete();
            $table->decimal('deposit_amount', 10, 2);
            $table->decimal('bonus_amount', 10, 2);
            $table->decimal('commission_rate', 5, 2)->default(10.00); // e.g. 10.00 = 10%
            $table->string('status', 20)->default('awarded'); // awarded | redeemed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_earnings');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by_id']);
            $table->dropColumn([
                'referral_code',
                'referred_by_id',
                'referral_balance',
                'total_referral_earnings',
            ]);
        });
    }
};
