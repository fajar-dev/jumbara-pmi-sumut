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
        Schema::create('acticity_participations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('participant_type_id');
            $table->integer('max_participant');
            $table->timestamps();

            $table->foreign('activity_id')
            ->references('id')
            ->on('activities')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('participant_type_id')
            ->references('id')
            ->on('participant_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->index('max_participant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acticity_participations');
    }
};
