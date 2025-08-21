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
        Schema::create('lixiudiy_pesanan', function (Blueprint $table) {
            $table->bigInteger('pesanan_id')->autoIncrement();
            $table->bigInteger('pesanan_produk');
            $table->bigInteger('pesanan_customer');
            $table->bigInteger('pesanan_keranjang');
            $table->datetime('pesanan_tanggal');
            $table->integer('pesanan_jumlah');
            $table->decimal('pesanan_total_harga', 10, 2);
            $table->string('pesanan_status')->default('pending'); // Default status is 'pending'

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
