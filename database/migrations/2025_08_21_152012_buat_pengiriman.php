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
        Schema::create('lixiudiy_pengiriman', function (Blueprint $table) {
            $table->bigInteger('pengiriman_id')->autoIncrement();
            $table->bigInteger('pengiriman_pesanan');
            $table->string('pengiriman_alamat');
            $table->string('pengiriman_jasakurir');
            $table->string('pengiriman_nomor_resi')->nullable();
            $table->dateTime('pengiriman_tanggal');
            $table->string('pengiriman_status')->default('pending'); // Default status is 'pending'
            $table->text('pengiriman_keterangan')->nullable();
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
