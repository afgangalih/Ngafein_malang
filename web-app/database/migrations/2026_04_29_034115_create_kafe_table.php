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
        Schema::create('kafe', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kafe')->primary();
            $table->string('nama_kafe');
            $table->text('alamat')->nullable();
            $table->text('link_maps')->nullable();
            $table->integer('harga_min')->default(0);
            $table->integer('harga_max')->default(0);
            $table->float('rating')->default(0);
            $table->float('jarak')->default(0);
            $table->string('jam_buka')->nullable();
            $table->string('jam_tutup')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kafe');
    }
};
