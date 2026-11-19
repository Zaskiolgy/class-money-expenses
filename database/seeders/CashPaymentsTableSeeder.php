<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CashPayment;
use App\Models\Student;
use App\Models\CashWeek;
use Carbon\Carbon;

class CashPaymentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $weeks    = CashWeek::all();

        // Week 1: 70% siswa sudah bayar (17 from 24)
        // Week 2: 70% (17)
        // Week 3: 50% (12)
        // Week 4: 30% (7)
        $paidCounts = [1 => 17, 2 => 17, 3 => 12, 4 => 7];

        foreach ($weeks as $week) {
            $count = $paidCounts[$week->week_number] ?? 0;
            $paidStudents = $students->shuffle()->take($count);

            foreach ($paidStudents as $student) {
                CashPayment::create([
                    'student_id'  => $student->id,
                    'cash_week_id' => $week->id,
                    'paid_at'     => Carbon::create(2026, 11, $week->week_number * 7 - 5),
                    'paid_by'     => 2, // Bendahara user id
                ]);
            }
        }
    }
}
