<?php

namespace Database\Seeders;

use App\Models\SteeringCommittee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SteeringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SteeringCommittee::create([
            'name' => 'Komite Pengarah',
            'email' => 'steering@sankyu.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
