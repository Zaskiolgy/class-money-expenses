<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::withCount('cashPayments')->orderBy('name')->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn'         => 'required|string|max:20|unique:students',
            'name'         => 'required|string|max:255',
            'gender'       => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:20',
        ]);

        Student::create($request->only('nisn', 'name', 'gender', 'phone_number'));
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nisn'         => 'required|string|max:20|unique:students,nisn,' . $student->id,
            'name'         => 'required|string|max:255',
            'gender'       => 'required|in:L,P',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $student->update($request->only('nisn', 'name', 'gender', 'phone_number'));
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return back()->with('success', 'Data siswa dihapus.');
    }
}
