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
        Schema::create('mobilitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_pegawai');
            $table->string('hari');
            $table->string('jam');
            $table->enum('keterangan', array('hadir', 'izin'));
            $table->text('alasan')->nullable();
            $table->string('file_izin')->nullable();
            $table->string('jam_izin')->nullable();
            $table->string('file_eviden')->nullable();
            $table->enum('status', ['verifikasi','ditolak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobilitas');
    }
};
