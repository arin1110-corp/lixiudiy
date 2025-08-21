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
        Schema::create('lixiudiy_customer', function (Blueprint $table) {
            $table->bigInteger('customer_id')->autoIncrement();
            $table->string('customer_nama');
            $table->string('customer_email')->unique();
            $table->string('customer_password');
            $table->date('customer_tanggaldaftar');
            $table->date('customer_tanggallahir');
            $table->string('customer_status')->default('1'); // Default status is 'active'
            $table->string('customer_alamat');
            $table->string('customer_telepon');
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
