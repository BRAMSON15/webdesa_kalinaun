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
        Schema::create('tbl_sekdes', function (Blueprint $table) {
            $table->id('id_sekdes');
            $table->string('username', 50);
            $table->string('password', 255);
            $table->timestamps();
            
            // Methods yang akan diimplementasi di Model
            // +validasi_akhir()
            // +lihat_laporan_arsip()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sekdes');
    }
};
