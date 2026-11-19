@extends('layouts.app')
@section('title', 'Data Pengeluaran')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Total Pengeluaran</p>
        <p class="text-2xl font-bold text-red-600">Rp {{ number_format($total, 0, ',', '.') }}</p>
    </div>
    @foreach($byCategory as $cat)
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">{{ $cat->category }}</p>
        <p class="text-xl font-bold text-gray-700">Rp {{ number_format($cat->total, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400">{{ $cat->count }} transaksi</p>
    </div>
    @endforeach
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-semibold text-gray-800">Daftar Pengeluaran</h2>
        <a href="{{ route('expenses.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengeluaran
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Judul</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nota</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jumlah</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($expenses as $expense)
                @php
                    $colors = ['ATK'=>'blue','Kebersihan'=>'green','Sosial'=>'pink','Acara'=>'purple','Lainnya'=>'gray'];
                    $c = $colors[$expense->category] ?? 'gray';
                @endphp
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-800">{{ $expense->title }}</p>
                        @if($expense->note)
                            <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ $expense->note }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $c }}-100 text-{{ $c }}-700">
                            {{ $expense->category }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $expense->expense_date->format('d M Y') }}</td>
                    <td class="px-5 py-3">
                        @if($expense->receipt_image)
                            <a href="{{ asset('storage/' . $expense->receipt_image) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-xs text-indigo-600 hover:underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Lihat Nota
                            </a>
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">
                        -Rp {{ number_format($expense->amount, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('expenses.edit', $expense) }}"
                               class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Edit</a>
                            <form method="POST" action="{{ route('expenses.destroy', $expense) }}"
                                  onsubmit="return confirm('Hapus data pengeluaran ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:text-red-700 font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400 text-sm">Belum ada data pengeluaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($expenses->hasPages())
    <div class="px-5 py-3 border-t border-gray-100">
        {{ $expenses->links() }}
    </div>
    @endif
</div>
@endsection
