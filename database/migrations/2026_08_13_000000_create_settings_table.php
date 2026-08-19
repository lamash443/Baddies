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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Unlock Exclusive Account banner settings
            $table->boolean('unlock_banner_enabled')->default(true);
            $table->string('unlock_banner_title')->default('Unlock Exclusive Account');
            $table->text('unlock_banner_description')->nullable();
            $table->string('unlock_banner_button_text')->default('Verify Account');

            // Complete Your Profile banner settings
            $table->boolean('profile_banner_enabled')->default(true);
            $table->string('profile_banner_title')->default('Complete Your Profile');
            $table->text('profile_banner_description')->nullable();
            $table->string('profile_banner_button_text')->default('Update Profile');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
