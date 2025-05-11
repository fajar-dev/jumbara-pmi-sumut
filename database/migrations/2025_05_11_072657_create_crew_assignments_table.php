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
        Schema::create('crew_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crew_id');
            $table->unsignedBigInteger('activity_id');
            $table->timestamps();

            $table->foreign('crew_id')
            ->references('id')
            ->on('crews')
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
        Schema::dropIfExists('crew_assignments');
    }
};
