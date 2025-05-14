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
        Schema::create('activity_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_assignment_id')->unique();
            $table->unsignedBigInteger('crew_assignment_id');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->timestamps();

            $table->foreign('participant_assignment_id')
            ->references('id')
            ->on('crew_assignments')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('crew_assignment_id')
            ->references('id')
            ->on('participant_assignments')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_attendances');
    }
};
