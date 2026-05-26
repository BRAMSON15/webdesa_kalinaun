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
        Schema::create('bansos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bansos');
            $table->text('deskripsi');
            $table->text('syarat_ketentuan')->nullable();
            $table->integer('kuota')->default(0);
            $table->integer('kuota_terpakai')->default(0);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['aktif', 'nonaktif', 'selesai'])->default('aktif');
            $table->decimal('nominal', 15, 2)->nullable();
            $table->string('jenis_bansos'); // contoh: uang tunai, sembako, beasiswa, dll
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bansos');
    }
};
