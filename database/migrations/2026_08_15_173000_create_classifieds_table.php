<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classifieds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('category', ['personals', 'jobs', 'massage', 'events']);
            $table->string('city')->nullable();
            $table->string('image_path')->nullable();
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('contact_name')->nullable();
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->decimal('amount', 8, 2)->default(1000.00);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classifieds');
    }
};
