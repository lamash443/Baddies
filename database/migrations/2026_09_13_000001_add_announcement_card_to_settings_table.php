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
        Schema::table('settings', function (Blueprint $table) {
            // Announcement Card (Dashboard)
            $table->boolean('announcement_card_enabled')->default(true)->after('profile_banner_button_text');
            $table->string('announcement_card_title')->default('Unlock Exclusive Account')->after('announcement_card_enabled');
            $table->text('announcement_card_description')->nullable()->after('announcement_card_title');
            $table->string('announcement_card_button_text')->default('Verify Account')->after('announcement_card_description');
            $table->string('announcement_card_button_url')->default('/verify-account')->after('announcement_card_button_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'announcement_card_enabled',
                'announcement_card_title',
                'announcement_card_description',
                'announcement_card_button_text',
                'announcement_card_button_url',
            ]);
        });
    }
};
