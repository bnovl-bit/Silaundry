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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('id_layanan'); // foreign key ke layanan
            $table->decimal('berat', 8, 2); 
            $table->string('nama_pelanggan', 255);
            $table->string('keterangan', 50); 
            $table->timestamps();

            // foreign key constraint
            $table->foreign('id_layanan')
                ->references('id') 
                ->on('layanan')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
