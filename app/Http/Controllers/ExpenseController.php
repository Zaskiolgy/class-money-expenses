<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('recorder')->latest('expense_date')->paginate(10);
        $total    = Expense::sum('amount');
        $byCategory = Expense::selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category')->get();
        return view('expenses.index', compact('expenses', 'total', 'byCategory'));
    }

    public function create()
    {
        $categories = ['ATK', 'Kebersihan', 'Sosial', 'Acara', 'Lainnya'];
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'amount'       => 'required|integer|min:1',
            'expense_date' => 'required|date',
            'category'     => 'required|in:ATK,Kebersihan,Sosial,Acara,Lainnya',
            'note'         => 'nullable|string',
            'receipt_image'=> 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('receipt_image')) {
            $data['receipt_image'] = $request->file('receipt_image')->store('receipts', 'public');
        }

        $data['recorded_by'] = auth()->id();
        Expense::create($data);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function edit(Expense $expense)
    {
        $categories = ['ATK', 'Kebersihan', 'Sosial', 'Acara', 'Lainnya'];
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'amount'       => 'required|integer|min:1',
            'expense_date' => 'required|date',
            'category'     => 'required|in:ATK,Kebersihan,Sosial,Acara,Lainnya',
            'note'         => 'nullable|string',
            'receipt_image'=> 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('receipt_image')) {
            if ($expense->receipt_image) {
                Storage::disk('public')->delete($expense->receipt_image);
            }
            $data['receipt_image'] = $request->file('receipt_image')->store('receipts', 'public');
        }

        $expense->update($data);
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diupdate!');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->receipt_image) {
            Storage::disk('public')->delete($expense->receipt_image);
        }
        $expense->delete();
        return back()->with('success', 'Data pengeluaran dihapus.');
    }
}
