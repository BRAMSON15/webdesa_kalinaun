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
        Schema::create('tbl_admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('username', 50);
            $table->string('password', 255);
            $table->timestamps();
            
            // Methods yang akan diimplementasi di Model
            // +verifikasi_berkas()
            // +kelola_arsip_desa()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_admin');
    }
};
