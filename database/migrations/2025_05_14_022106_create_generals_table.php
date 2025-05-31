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
        Schema::create('generals', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('guidebook');
            $table->string('title');
            $table->string('subtitle');
            $table->string('location');
            $table->date('event_start');
            $table->date('event_end');
            $table->timestamp('last_registration');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('instagram');
            $table->string('facebook');
            $table->string('youtube');
            $table->string('tiktok');
            $table->string('website');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generals');
    }
};
