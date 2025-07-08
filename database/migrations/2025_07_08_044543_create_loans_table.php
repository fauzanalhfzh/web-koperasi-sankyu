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
            $table->date('jangka_waktu');
            $table->boolean('status_pinjaman')->default(false);
            $table->integer('bunga');
            $table->boolean('status_pengajuan');
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
