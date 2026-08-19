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
        Schema::table('user_videos', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('path');
        });
    }

    public function down(): void
    {
        Schema::table('user_videos', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};
