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
        Schema::create('secretariats', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['Markas', 'Unit']);
            $table->enum('type', ['UNIT DONOR DARAH', 'RUMAH SAKIT', 'PUSAT', 'PROVINSI', 'KABUPATEN', 'KOTA', 'KECAMATAN', 'MASYARAKAT/SIBAT', 'MULA', 'MADYA', 'WIRA', 'PERGURUAN TINGGI', 'MARKAS', 'KAB-KOTA', 'Perusahaan']);
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('administrative_area_level_1');
            $table->string('administrative_area_level_2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secretariats');
    }
};
