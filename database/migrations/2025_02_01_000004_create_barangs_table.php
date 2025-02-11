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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')->constrained('kategoris');
            $table->string('nama_barang', 100);
            $table->text('detail_barang');
            $table->decimal('berat');
            $table->integer('harga_jual')->nullable();
            $table->integer('harga_beli')->nullable();
            $table->longText('foto');
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
