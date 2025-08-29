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
        Schema::create('lixiudiy_kurir', function (Blueprint $table) {
            $table->increments('kurir_id');
            $table->string('kurir_nama', 50);
            $table->string('kurir_notelp', 15);
            $table->string('kurir_alamat', 100);
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
