<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jumlah_pinjaman = $this->faker->numberBetween(1000000, 20000000);
        $jangka_waktu = $this->faker->numberBetween(6, 36); // bulan
        $bunga = $this->faker->randomFloat(2, 0.5, 2.5); // bunga persen per bulan
        $cicilan = ceil(($jumlah_pinjaman + ($jumlah_pinjaman * ($bunga / 100) * $jangka_waktu)) / $jangka_waktu);

        return [
            'member_id' => Member::inRandomOrder()->first()->id,
            'jumlah_pinjaman' => $jumlah_pinjaman,
            'tanggal_pengajuan' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'jangka_waktu' => $jangka_waktu,
            'cicilan' => $cicilan,
            'bunga' => $bunga,
            'status_pinjaman' => $this->faker->randomElement(['lunas', 'belum_lunas']),
            'status_pengajuan' => $this->faker->randomElement(['pending', 'diterima', 'ditolak']),
        ];
    }
}
