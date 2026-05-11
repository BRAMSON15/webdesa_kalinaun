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
        Schema::create('tbl_pengajuan_surat', function (Blueprint $table) {
            $table->id('id_surat');
            $table->unsignedBigInteger('id_masyarakat');
            $table->text('keterangan');
            $table->date('tgl_pengajuan');
            $table->string('jenis_surat', 50);
            $table->enum('status', ['proses', 'selesai', 'ditolak'])->default('proses');
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('id_masyarakat')->references('id_masyarakat')->on('tbl_masyarakat')->onDelete('cascade');
            
            // Methods yang akan diimplementasi di Model
            // +cek_status()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pengajuan_surat');
    }
};
