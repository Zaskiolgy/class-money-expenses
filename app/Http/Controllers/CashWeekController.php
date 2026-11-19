<?php

namespace App\Http\Controllers;

use App\Models\CashWeek;
use Illuminate\Http\Request;

class CashWeekController extends Controller
{
    public function index()
    {
        $cashWeeks = CashWeek::withCount('cashPayments')->orderBy('year')->orderBy('month')->orderBy('week_number')->get();
        return view('cash-weeks.index', compact('cashWeeks'));
    }

    public function create()
    {
        return view('cash-weeks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'       => 'required|string|max:100',
            'week_number' => 'required|integer|min:1|max:5',
            'month'       => 'required|integer|min:1|max:12',
            'year'        => 'required|integer|min:2020|max:2100',
            'amount'      => 'required|integer|min:1000',
        ]);

        CashWeek::create($request->only('label', 'week_number', 'month', 'year', 'amount'));
        return redirect()->route('cash-weeks.index')->with('success', 'Periode kas berhasil ditambahkan!');
    }

    public function destroy(CashWeek $cashWeek)
    {
        $cashWeek->delete();
        return back()->with('success', 'Periode kas dihapus.');
    }
}
