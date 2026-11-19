<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CashPaymentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CashWeekController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Siswa
    Route::resource('students', StudentController::class)->except(['show']);

    // Periode Kas
    Route::resource('cash-weeks', CashWeekController::class)->except(['show', 'edit', 'update']);

    // Matriks Pembayaran Kas
    Route::get('/cash-payments', [CashPaymentController::class, 'index'])->name('cash-payments.index');
    Route::post('/cash-payments/toggle', [CashPaymentController::class, 'toggle'])->name('cash-payments.toggle');
    Route::post('/cash-payments/bulk', [CashPaymentController::class, 'payBulk'])->name('cash-payments.bulk');

    // Pemasukan
    Route::resource('incomes', IncomeController::class)->except(['show']);

    // Pengeluaran
    Route::resource('expenses', ExpenseController::class)->except(['show']);
});
