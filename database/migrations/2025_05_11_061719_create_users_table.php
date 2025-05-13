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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('religion_id');
            $table->unsignedBigInteger('blood_type_id');
            $table->string('phone_number')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('password');
            $table->boolean('is_default')->default(true);
            $table->string('photo_path')->nullable();
            $table->unsignedBigInteger('secretariat_id');
            $table->unsignedBigInteger('member_type_id');
            $table->text('address')->nullable();
            $table->rememberToken();
            $table->timestamp('joined_at')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->foreign('gender_id')
            ->references('id')
            ->on('genders')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('religion_id')
            ->references('id')
            ->on('religions')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('blood_type_id')
            ->references('id')
            ->on('blood_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('secretariat_id')
            ->references('id')
            ->on('secretariats')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('member_type_id')
            ->references('id')
            ->on('member_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
