<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'nama_lengkap' => $this->faker->name,
            'nik' => $this->faker->unique()->nik(),
            'no_rekening' => $this->faker->unique()->bankAccountNumber(),
            'jabatan' => $this->faker->randomElement(['Operator', 'Supervisor', 'Manager']),
            'site' => $this->faker->randomElement(['Cilegon', 'Jakarta', 'Karawang']),
            'gaji_pokok' => $this->faker->numberBetween(3000000, 10000000),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password123'), // default password
        ];
    }
}
