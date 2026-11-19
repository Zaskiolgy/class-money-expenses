<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Income;

class IncomesTableSeeder extends Seeder
{
    public function run(): void
    {
        $incomes = [
            [
                'title'       => 'Sumbangan Sukarela Alumni',
                'amount'      => 100000,
                'income_date' => '2026-11-05',
                'category'    => 'Sumbangan',
                'note'        => 'Dari kakak kelas alumni yang mengunjungi kelas',
                'recorded_by' => 2,
            ],
            [
                'title'       => 'Kembalian Uang Fotokopi',
                'amount'      => 7000,
                'income_date' => '2026-11-12',
                'category'    => 'Lainnya',
                'note'        => 'Sisa kembalian dari fotokopi bahan presentasi',
                'recorded_by' => 2,
            ],
            [
                'title'       => 'Iuran Tambahan Acara Perpisahan',
                'amount'      => 120000,
                'income_date' => '2026-11-15',
                'category'    => 'Iuran',
                'note'        => 'Iuran tambahan Rp 5.000 per siswa (24 siswa) untuk persiapan acara perpisahan',
                'recorded_by' => 2,
            ],
        ];

        foreach ($incomes as $income) {
            Income::create($income);
        }
    }
}
