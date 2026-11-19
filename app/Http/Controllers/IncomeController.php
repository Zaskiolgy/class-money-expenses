<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes    = Income::with('recorder')->latest('income_date')->paginate(10);
        $total      = Income::sum('amount');
        $byCategory = Income::selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category')->get();
        return view('incomes.index', compact('incomes', 'total', 'byCategory'));
    }

    public function create()
    {
        $categories = ['Iuran', 'Sumbangan', 'Lainnya'];
        return view('incomes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|integer|min:1',
            'income_date' => 'required|date',
            'category'    => 'required|in:Iuran,Sumbangan,Lainnya',
            'note'        => 'nullable|string',
        ]);

        $data['recorded_by'] = auth()->id();
        Income::create($data);

        return redirect()->route('incomes.index')->with('success', 'Pemasukan berhasil dicatat!');
    }

    public function edit(Income $income)
    {
        $categories = ['Iuran', 'Sumbangan', 'Lainnya'];
        return view('incomes.edit', compact('income', 'categories'));
    }

    public function update(Request $request, Income $income)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|integer|min:1',
            'income_date' => 'required|date',
            'category'    => 'required|in:Iuran,Sumbangan,Lainnya',
            'note'        => 'nullable|string',
        ]);

        $income->update($data);
        return redirect()->route('incomes.index')->with('success', 'Pemasukan berhasil diupdate!');
    }

    public function destroy(Income $income)
    {
        $income->delete();
        return back()->with('success', 'Data pemasukan dihapus.');
    }
}
