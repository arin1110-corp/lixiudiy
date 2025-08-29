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
        Schema::create('lixiudiy_aktivasi_akun', function (Blueprint $table) {
            $table->increments('aktivasi_id');
            $table->integer('aktivasi_customer');
            $table->string('aktivasi_token', 100);
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
