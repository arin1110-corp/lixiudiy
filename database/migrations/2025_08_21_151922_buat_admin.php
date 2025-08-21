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
        Schema::create('lixiudiy_admin', function (Blueprint $table) {
            $table->bigInteger('admin_id')->autoIncrement();
            $table->string('admin_nama');
            $table->string('admin_email');
            $table->string('admin_password');
            $table->date('admin_tanggaldibuat');
            $table->string('admin_status')->default('1'); // Default status is 'active'
        });
        // Optionally, you can add foreign keys or other constraints here
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
