<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realisasi_retribusis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upload_id')->nullable()->constrained('upload_retribusis')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('kode_rekening');
            $table->string('nama_retribusi');
            $table->string('opd_name');
            $table->decimal('nilai', 15, 2);
            $table->string('periode');
            $table->integer('tahun');
            $table->date('tanggal_realisasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realisasi_retribusis');
    }
};
