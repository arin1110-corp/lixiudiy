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
        //
        Schema::create('lixiudiy_kategori', function (Blueprint $table) {
            $table->bigInteger('kategori_id')->autoIncrement();
            $table->string('kategori_nama');
            $table->string('kategori_deskripsi')->nullable();
            $table->string('kategori_gambar')->nullable();
            $table->string('kategori_status')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
