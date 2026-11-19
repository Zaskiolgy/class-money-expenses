<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            StudentsTableSeeder::class,
            CashWeeksTableSeeder::class,
            CashPaymentsTableSeeder::class,
            ExpensesTableSeeder::class,
            IncomesTableSeeder::class,
        ]);
    }
}
