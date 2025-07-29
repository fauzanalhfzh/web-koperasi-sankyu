<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Saving;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = Member::all();

        foreach ($members as $member) {
            // Buat 3-10 data simpanan per member
            Saving::factory()->count(rand(3, 10))->create([
                'member_id' => $member->id,
            ]);
        }
    }
}
