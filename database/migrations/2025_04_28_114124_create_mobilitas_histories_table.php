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
        Schema::create('mobilitas_histories', function (Blueprint $table) {
            $table->id();
            $table->string('mobilitas_id')->constrained('mobilitas')->onDelete('cascade');
            $table->foreignId('pegawai_awal_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pegawai_pengganti_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobilitas_histories');
    }
};
