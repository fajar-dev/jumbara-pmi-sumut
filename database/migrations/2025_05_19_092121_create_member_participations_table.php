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
        Schema::create('member_participations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_type_id');
            $table->unsignedBigInteger('participant_type_id');
            $table->timestamps();

            $table->foreign('member_type_id')
            ->references('id')
            ->on('member_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('participant_type_id')
            ->references('id')
            ->on('participant_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_participations');
    }
};
