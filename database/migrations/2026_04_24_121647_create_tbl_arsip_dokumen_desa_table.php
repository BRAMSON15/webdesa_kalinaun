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
        Schema::create('tbl_arsip_dokumen_desa', function (Blueprint $table) {
            $table->id('id_arsip');
            $table->string('judul_dokumen', 100);
            $table->enum('kategori', ['Perdes', 'SK Kades', 'Aset', 'Lainnya']);
            $table->string('file_path', 255);
            $table->unsignedBigInteger('id_admin');
            $table->timestamp('tgl_upload');
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('id_admin')->references('id_admin')->on('tbl_admin')->onDelete('cascade');
            
            // Note: Tabel khusus dokumen internal (Bukan surat warga)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_arsip_dokumen_desa');
    }
};
