<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CashWeek;

class CashWeeksTableSeeder extends Seeder
{
    public function run(): void
    {
        $weeks = [
            ['label' => 'Minggu 1 November 2026', 'week_number' => 1, 'month' => 11, 'year' => 2026, 'amount' => 5000],
            ['label' => 'Minggu 2 November 2026', 'week_number' => 2, 'month' => 11, 'year' => 2026, 'amount' => 5000],
            ['label' => 'Minggu 3 November 2026', 'week_number' => 3, 'month' => 11, 'year' => 2026, 'amount' => 5000],
            ['label' => 'Minggu 4 November 2026', 'week_number' => 4, 'month' => 11, 'year' => 2026, 'amount' => 5000],
        ];

        foreach ($weeks as $week) {
            CashWeek::create($week);
        }
    }
}
