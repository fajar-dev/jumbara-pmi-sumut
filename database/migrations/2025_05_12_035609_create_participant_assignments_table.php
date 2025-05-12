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
        Schema::create('participant_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id');
            $table->unsignedBigInteger('activity_id');
            $table->timestamps();

            $table->foreign('participant_id')
            ->references('id')
            ->on('participants')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->foreign('activity_id')
            ->references('id')
            ->on('activities')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_assignments');
    }
};
