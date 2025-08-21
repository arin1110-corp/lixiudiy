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
        Schema::create('lixiudiy_keranjang', function (Blueprint $table) {
            $table->bigInteger('keranjang_id')->autoIncrement();
            $table->bigInteger('keranjang_produk');
            $table->bigInteger('keranjang_customer');
            $table->integer('keranjang_jumlah');
            $table->decimal('keranjang_total_harga', 10, 2);
            $table->dateTime('keranjang_tanggal');
            $table->string('keranjang_status')->default('active'); // Default status is 'active'
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
