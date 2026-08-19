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
            $table->string('phone_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('sexual_orientation')->nullable();
            $table->integer('age')->nullable();
            $table->string('nationality')->nullable();
            $table->string('county')->nullable();
            $table->string('city_town')->nullable();
            $table->string('location')->nullable();
            $table->string('area')->nullable();
            $table->text('nearby_places')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_number',
                'gender',
                'sexual_orientation',
                'age',
                'nationality',
                'county',
                'city_town',
                'location',
                'area',
                'nearby_places',
            ]);
        });
    }
};
