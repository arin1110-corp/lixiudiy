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
        Schema::create('lixiudiy_laporan_penjualan', function (Blueprint $table) {
            $table->bigInteger('laporan_id')->autoIncrement();
            $table->date('laporan_tanggal');
            $table->bigInteger('laporan_total_produk');
            $table->date('laporan_periode_mulai');
            $table->date('laporan_periode_selesai');
            $table->bigInteger('laporan_total_pesanan');
            $table->decimal('laporan_total_pendapatan', 10, 2);
            $table->text('laporan_keterangan')->nullable();
            $table->string('laporan_status')->default('active'); // Default status is 'active'
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
