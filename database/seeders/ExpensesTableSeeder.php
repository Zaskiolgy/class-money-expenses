<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expense;

class ExpensesTableSeeder extends Seeder
{
    public function run(): void
    {
        $expenses = [
            [
                'title'        => 'Beli Spidol Whiteboard (3 pcs)',
                'amount'       => 22500,
                'expense_date' => '2026-11-04',
                'category'     => 'ATK',
                'note'         => 'Spidol merah, biru, hitam untuk papan tulis kelas',
                'recorded_by'  => 2,
            ],
            [
                'title'        => 'Beli Penghapus & Spons Papan Tulis',
                'amount'       => 10000,
                'expense_date' => '2026-11-04',
                'category'     => 'ATK',
                'note'         => 'Penghapus papan tulis baru',
                'recorded_by'  => 2,
            ],
            [
                'title'        => 'Sapu & Pengki Kelas',
                'amount'       => 35000,
                'expense_date' => '2026-11-07',
                'category'     => 'Kebersihan',
                'note'         => 'Sapu ijuk 1 buah dan pengki plastik 1 buah',
                'recorded_by'  => 2,
            ],
            [
                'title'        => 'Kantong Sampah (1 pack)',
                'amount'       => 12000,
                'expense_date' => '2026-11-07',
                'category'     => 'Kebersihan',
                'note'         => '1 pak isi 10 lembar kantong sampah ukuran besar',
                'recorded_by'  => 2,
            ],
            [
                'title'        => 'Fotokopi Bahan Presentasi Kelompok',
                'amount'       => 18000,
                'expense_date' => '2026-11-12',
                'category'     => 'ATK',
                'note'         => 'Fotokopi materi untuk 5 kelompok, 6 lembar per kelompok',
                'recorded_by'  => 2,
            ],
            [
                'title'        => 'Uang Duka Teman Sakit (Raka)',
                'amount'       => 50000,
                'expense_date' => '2026-11-14',
                'category'     => 'Sosial',
                'note'         => 'Sumbangan dari kas kelas untuk siswa yang dirawat di rumah sakit',
                'recorded_by'  => 2,
            ],
        ];

        foreach ($expenses as $expense) {
            Expense::create($expense);
        }
    }
}
