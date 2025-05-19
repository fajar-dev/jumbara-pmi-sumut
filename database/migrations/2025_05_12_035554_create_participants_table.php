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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('contingent_id');
            $table->unsignedBigInteger('participant_type_id');
            $table->string('health_certificate')->nullable();
            $table->string('assignment_letter')->nullable();
            $table->boolean('is_draft')->default('true');
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('contingent_id')
            ->references('id')
            ->on('contingents')
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
        Schema::dropIfExists('participants');
    }
};
