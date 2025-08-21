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
        Schema::create('lixiudiy_produk', function (Blueprint $table) {
            $table->bigInteger('produk_id')->autoIncrement();
            $table->string('produk_nama');
            $table->text('produk_deskripsi')->nullable();
            $table->decimal('produk_harga', 10, 2);
            $table->date('produk_tanggalmasuk');
            $table->integer('produk_stok');
            $table->string('produk_gambar')->nullable();
            $table->string('produk_status')->default('1');
            $table->bigInteger('produk_kategori');
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
