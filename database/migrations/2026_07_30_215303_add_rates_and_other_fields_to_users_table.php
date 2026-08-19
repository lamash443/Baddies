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
        Schema::table('users', function (Blueprint $table) {
            $table->text('other_services')->nullable();
            $table->integer('incalls_rate')->nullable();
            $table->integer('outcalls_rate')->nullable();
            $table->text('other_cities')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'other_services',
                'incalls_rate',
                'outcalls_rate',
                'other_cities',
            ]);
        });
    }
};
