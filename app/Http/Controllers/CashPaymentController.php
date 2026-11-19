<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\CashWeek;
use App\Models\CashPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CashPaymentController extends Controller
{
    public function index()
    {
        $students  = Student::orderBy('name')->get();
        $cashWeeks = CashWeek::orderBy('week_number')->get();

        // Buat map: student_id => [week_id => true/false]
        $payments = CashPayment::all()->groupBy('student_id');
        $paymentMap = [];
        foreach ($students as $student) {
            foreach ($cashWeeks as $week) {
                $paymentMap[$student->id][$week->id] = $payments->get($student->id)
                    ?->firstWhere('cash_week_id', $week->id) !== null;
            }
        }

        return view('cash-payments.index', compact('students', 'cashWeeks', 'paymentMap'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'cash_week_id' => 'required|exists:cash_weeks,id',
        ]);

        $existing = CashPayment::where('student_id', $request->student_id)
            ->where('cash_week_id', $request->cash_week_id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed', 'message' => 'Pembayaran dibatalkan']);
        }

        CashPayment::create([
            'student_id'   => $request->student_id,
            'cash_week_id' => $request->cash_week_id,
            'paid_at'      => Carbon::now(),
            'paid_by'      => auth()->id(),
        ]);

        return response()->json(['status' => 'paid', 'message' => 'Pembayaran dicatat!']);
    }

    public function payBulk(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'week_ids'   => 'required|array',
            'week_ids.*' => 'exists:cash_weeks,id',
        ]);

        $count = 0;
        foreach ($request->week_ids as $weekId) {
            $exists = CashPayment::where('student_id', $request->student_id)
                ->where('cash_week_id', $weekId)->exists();

            if (!$exists) {
                CashPayment::create([
                    'student_id'   => $request->student_id,
                    'cash_week_id' => $weekId,
                    'paid_at'      => Carbon::now(),
                    'paid_by'      => auth()->id(),
                ]);
                $count++;
            }
        }

        return back()->with('success', "{$count} pembayaran berhasil dicatat!");
    }
}
