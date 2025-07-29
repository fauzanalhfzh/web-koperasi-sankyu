<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = Member::all();

        foreach ($members as $member) {
            // 0-1 pinjaman per member
            Loan::factory()->count(rand(0, 1))->create([
                'member_id' => $member->id,
            ]);
        }
    }
}
