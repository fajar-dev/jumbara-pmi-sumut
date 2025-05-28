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
        Schema::create('contingent_leaders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id')->unique();
            $table->timestamps();

            $table->foreign('participant_id')
            ->references('id')
            ->on('participants')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contingent_leaders');
    }
};
