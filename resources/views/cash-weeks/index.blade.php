@extends('layouts.app')
@section('title', 'Periode Kas')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-gray-800">Daftar Periode Minggu Kas</h2>
            <p class="text-xs text-gray-400 mt-0.5">Atur minggu iuran uang kas kelas (Rp 5.000 / minggu)</p>
        </div>
        <a href="{{ route('cash-weeks.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Periode
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Label Periode</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Minggu Ke-</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Bulan / Tahun</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nominal Tagihan</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Siswa Membayar</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($cashWeeks as $week)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3 font-medium text-gray-800">{{ $week->label }}</td>
                    <td class="px-5 py-3 text-center text-gray-600">Minggu {{ $week->week_number }}</td>
                    <td class="px-5 py-3 text-center text-gray-600">{{ DateTime::createFromFormat('!m', $week->month)->format('F') }} {{ $week->year }}</td>
                    <td class="px-5 py-3 text-right font-medium text-gray-800">Rp {{ number_format($week->amount, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                            {{ $week->cash_payments_count }} / 24 siswa
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <form method="POST" action="{{ route('cash-weeks.destroy', $week) }}"
                              onsubmit="return confirm('Hapus periode ini? Semua data pembayaran terkait akan ikut terhapus!')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-500 hover:text-red-700 font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400 text-sm">Belum ada periode kas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
