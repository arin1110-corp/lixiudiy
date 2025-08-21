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
        Schema::create('lixiudiy_rekomendasi_produk', function (Blueprint $table) {
            $table->bigInteger('rekomendasi_id')->autoIncrement();
            $table->string('rekomendasi_nama');
            $table->bigInteger('rekomendasi_produk');
            $table->dateTime('rekomendasi_tanggal');
            $table->string('rekomendasi_status')->default('active'); // Default status is 'active'
            $table->text('rekomendasi_keterangan');
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
