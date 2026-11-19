<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['nisn' => '0051234001', 'name' => 'Aditya Pratama',       'gender' => 'L', 'phone_number' => '081234560001'],
            ['nisn' => '0051234002', 'name' => 'Bagas Saputra',        'gender' => 'L', 'phone_number' => '081234560002'],
            ['nisn' => '0051234003', 'name' => 'Citra Dewi Lestari',   'gender' => 'P', 'phone_number' => '081234560003'],
            ['nisn' => '0051234004', 'name' => 'Dian Rahmawati',       'gender' => 'P', 'phone_number' => '081234560004'],
            ['nisn' => '0051234005', 'name' => 'Eko Susanto',          'gender' => 'L', 'phone_number' => '081234560005'],
            ['nisn' => '0051234006', 'name' => 'Fajar Ramadhan',       'gender' => 'L', 'phone_number' => '081234560006'],
            ['nisn' => '0051234007', 'name' => 'Gita Nuraini',         'gender' => 'P', 'phone_number' => '081234560007'],
            ['nisn' => '0051234008', 'name' => 'Hendra Gunawan',       'gender' => 'L', 'phone_number' => '081234560008'],
            ['nisn' => '0051234009', 'name' => 'Indah Permatasari',    'gender' => 'P', 'phone_number' => '081234560009'],
            ['nisn' => '0051234010', 'name' => 'Joko Purnomo',         'gender' => 'L', 'phone_number' => '081234560010'],
            ['nisn' => '0051234011', 'name' => 'Kartika Sari',         'gender' => 'P', 'phone_number' => '081234560011'],
            ['nisn' => '0051234012', 'name' => 'Lukman Hakim',         'gender' => 'L', 'phone_number' => '081234560012'],
            ['nisn' => '0051234013', 'name' => 'Maya Anggraini',       'gender' => 'P', 'phone_number' => '081234560013'],
            ['nisn' => '0051234014', 'name' => 'Nanang Setiawan',      'gender' => 'L', 'phone_number' => '081234560014'],
            ['nisn' => '0051234015', 'name' => 'Oktavia Rahayu',       'gender' => 'P', 'phone_number' => '081234560015'],
            ['nisn' => '0051234016', 'name' => 'Putra Firmansyah',     'gender' => 'L', 'phone_number' => '081234560016'],
            ['nisn' => '0051234017', 'name' => 'Qonita Zahrotul',      'gender' => 'P', 'phone_number' => '081234560017'],
            ['nisn' => '0051234018', 'name' => 'Rizky Nugroho',        'gender' => 'L', 'phone_number' => '081234560018'],
            ['nisn' => '0051234019', 'name' => 'Siti Fatimah',         'gender' => 'P', 'phone_number' => '081234560019'],
            ['nisn' => '0051234020', 'name' => 'Tri Wahyudi',          'gender' => 'L', 'phone_number' => '081234560020'],
            ['nisn' => '0051234021', 'name' => 'Uswatun Hasanah',      'gender' => 'P', 'phone_number' => '081234560021'],
            ['nisn' => '0051234022', 'name' => 'Vicky Ardiansyah',     'gender' => 'L', 'phone_number' => '081234560022'],
            ['nisn' => '0051234023', 'name' => 'Winda Kusuma',         'gender' => 'P', 'phone_number' => '081234560023'],
            ['nisn' => '0051234024', 'name' => 'Yoga Prasetyo',        'gender' => 'L', 'phone_number' => '081234560024'],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
