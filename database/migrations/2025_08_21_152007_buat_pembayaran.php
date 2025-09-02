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
        Schema::create('lixiudiy_pembayaran', function (Blueprint $table) {
            $table->bigInteger('pembayaran_id')->autoIncrement();
            $table->string('pembayaran_pesanan', 100);
            $table->decimal('pembayaran_jumlah', 10, 2);
            $table->date('pembayaran_tanggal');
            $table->string('pembayaran_metode');
            $table->string('pembayaran_status')->default('pending'); // Default status is 'pending'
            $table->text('pembayaran_keterangan')->nullable();
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
