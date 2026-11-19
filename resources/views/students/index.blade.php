@extends('layouts.app')
@section('title', 'Data Siswa')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-gray-800">Daftar Siswa</h2>
            <p class="text-xs text-gray-400 mt-0.5">Total: {{ $students->count() }} siswa</p>
        </div>
        <a href="{{ route('students.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Siswa
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide w-8">#</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">NISN</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">JK</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">No. WA</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Bayar</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($students as $i => $student)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-semibold
                                {{ $student->gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <span class="font-medium text-gray-800">{{ $student->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-500 font-mono text-xs">{{ $student->nisn }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $student->gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                            {{ $student->gender === 'L' ? 'L' : 'P' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $student->phone_number ?? '—' }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-sm font-semibold {{ $student->cash_payments_count > 0 ? 'text-indigo-600' : 'text-gray-400' }}">
                            {{ $student->cash_payments_count }}x
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('students.edit', $student) }}"
                               class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Edit</a>
                            <form method="POST" action="{{ route('students.destroy', $student) }}"
                                  onsubmit="return confirm('Hapus data siswa {{ $student->name }}?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:text-red-700 font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-10 text-gray-400 text-sm">Belum ada data siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
