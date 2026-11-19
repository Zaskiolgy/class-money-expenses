<?php

namespace App\Http\Controllers;

use App\Models\CashWeek;
use App\Models\Student;
use App\Models\CashPayment;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $students      = Student::count();
        $cashWeeks     = CashWeek::all();
        $totalWeeks    = $cashWeeks->count();

        // Hitung total kas dari iuran mingguan
        $totalFromWeekly = CashPayment::count() * 5000;

        // Total pemasukan tambahan (income manual)
        $totalIncome = Income::sum('amount');

        // Total pengeluaran
        $totalExpense = Expense::sum('amount');

        // Saldo kas = iuran mingguan + pemasukan lain - pengeluaran
        $saldo = $totalFromWeekly + $totalIncome - $totalExpense;

        // Statistik per minggu untuk chart
        $weeklyStats = $cashWeeks->map(function ($week) {
            return [
                'label'     => 'Minggu ' . $week->week_number,
                'paid'      => $week->cashPayments()->count(),
                'unpaid'    => Student::count() - $week->cashPayments()->count(),
                'collected' => $week->cashPayments()->count() * $week->amount,
            ];
        });

        // Pemasukan vs Pengeluaran per bulan (November 2026)
        $monthlyIncome  = $totalFromWeekly + Income::whereMonth('income_date', 11)->whereYear('income_date', 2026)->sum('amount');
        $monthlyExpense = Expense::whereMonth('expense_date', 11)->whereYear('expense_date', 2026)->sum('amount');

        // Pengeluaran per kategori
        $expenseByCategory = Expense::selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        // 5 siswa dengan tunggakan terbanyak
        $debtors = Student::with('cashPayments')
            ->get()
            ->map(function ($student) use ($totalWeeks) {
                $paid   = $student->cashPayments->count();
                $unpaid = $totalWeeks - $paid;
                return [
                    'name'   => $student->name,
                    'unpaid' => $unpaid,
                    'amount' => $unpaid * 5000,
                ];
            })
            ->where('unpaid', '>', 0)
            ->sortByDesc('unpaid')
            ->take(5)
            ->values();

        // Transaksi terakhir (expense + income)
        $recentExpenses = Expense::latest()->take(3)->get();
        $recentIncomes  = Income::latest()->take(3)->get();

        return view('dashboard', compact(
            'students', 'totalWeeks', 'saldo',
            'totalFromWeekly', 'totalIncome', 'totalExpense',
            'weeklyStats', 'monthlyIncome', 'monthlyExpense',
            'expenseByCategory', 'debtors',
            'recentExpenses', 'recentIncomes'
        ));
    }
}
