<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('online_toast_enabled')->default(true);
            $table->boolean('show_online_status_in_chat')->default(true);
            $table->string('online_toast_message')->nullable(); // null means use global default
            $table->string('online_toast_position')->nullable(); // null means use global default
            $table->integer('online_toast_duration')->nullable(); // null means use global default
            $table->string('online_toast_sound')->nullable(); // null means use global default
            $table->integer('online_threshold_minutes')->nullable(); // null means use global default
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'online_toast_enabled',
                'show_online_status_in_chat',
                'online_toast_message',
                'online_toast_position',
                'online_toast_duration',
                'online_toast_sound',
                'online_threshold_minutes',
            ]);
        });
    }
};
