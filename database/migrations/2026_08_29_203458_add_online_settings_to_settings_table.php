<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Online status notification controls
            $table->boolean('online_toast_enabled')->default(true)->after('profile_banner_button_text');
            $table->string('online_toast_message')->default('💚 {name} is now online!')->after('online_toast_enabled');
            $table->integer('online_toast_duration')->default(4000)->after('online_toast_message'); // ms
            $table->string('online_toast_position')->default('bottom-right')->after('online_toast_duration');
            $table->string('online_toast_sound')->default('none')->after('online_toast_position'); // none, ping, chime
            $table->boolean('show_online_status_in_chat')->default(true)->after('online_toast_sound');
            $table->integer('online_threshold_minutes')->default(5)->after('show_online_status_in_chat');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'online_toast_enabled',
                'online_toast_message',
                'online_toast_duration',
                'online_toast_position',
                'online_toast_sound',
                'show_online_status_in_chat',
                'online_threshold_minutes',
            ]);
        });
    }
};
