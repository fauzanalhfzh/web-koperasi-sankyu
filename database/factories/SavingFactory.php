<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Saving>
 */
class SavingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => Member::inRandomOrder()->first()->id,
            'jenis_simpanan' => $this->faker->randomElement(['wajib', 'pokok']),
            'jumlah_simpanan' => $this->faker->numberBetween(50000, 1000000),
            'tanggal_transaksi' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'keterangan' => $this->faker->optional()->sentence(),
        ];
    }
}
