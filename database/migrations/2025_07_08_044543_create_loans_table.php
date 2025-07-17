<?php

use App\Models\Member;
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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Member::class);
            $table->integer('jumlah_pinjaman');
            $table->date('tanggal_pengajuan');
            $table->integer('jangka_waktu');
            $table->integer('cicilan');
            $table->integer('bunga');
            $table->enum('status_pinjaman', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->enum('status_pengajuan', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
