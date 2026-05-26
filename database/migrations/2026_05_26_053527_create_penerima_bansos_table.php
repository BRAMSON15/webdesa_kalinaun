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
        Schema::create('penerima_bansos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bansos_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nik');
            $table->string('nama_penerima');
            $table->string('alamat');
            $table->string('no_hp')->nullable();
            $table->enum('status', ['disetujui', 'ditolak', 'menunggu'])->default('menunggu');
            $table->text('alasan_penolakan')->nullable();
            $table->decimal('nominal_diterima', 15, 2)->nullable();
            $table->date('tanggal_penerimaan')->nullable();
            $table->string('bukti_penerimaan')->nullable(); // file path
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('bansos_id')->references('id')->on('bansos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Unique constraint untuk mencegah duplikasi
            $table->unique(['bansos_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_bansos');
    }
};
