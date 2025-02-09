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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_member')->constrained('users');
            $table->datetime('waktu');
            $table->datetime('batas_waktu');
            $table->bigInteger('total');
            $table->longText('bukti_bayar');
            $table->enum('status', ['Dipesan', 'Dikirim', 'Diterima', 'Dibatalkan']);
            $table->string('no_resi', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
