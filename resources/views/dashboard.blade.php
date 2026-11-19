@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
{{-- Stat Cards Row --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Saldo Kas</p>
            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">Total saldo tersedia</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pemasukan</p>
            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-emerald-700">Rp {{ number_format($totalFromWeekly + $totalIncome, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">Iuran + pemasukan lain</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pengeluaran</p>
            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">Total pengeluaran</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Siswa</p>
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $students }}</p>
        <p class="text-xs text-gray-400 mt-1">Total anggota kelas</p>
    </div>
</div>

{{-- Charts Row --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

    {{-- Bar Chart: Pembayaran per Minggu --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Pembayaran per Minggu</h3>
                <p class="text-xs text-gray-400">Jumlah siswa yang sudah & belum bayar</p>
            </div>
        </div>
        <canvas id="weeklyChart" height="120"></canvas>
    </div>

    {{-- Doughnut Chart: Pengeluaran per Kategori --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-700">Pengeluaran per Kategori</h3>
            <p class="text-xs text-gray-400">Distribusi penggunaan kas</p>
        </div>
        <canvas id="categoryChart" height="180"></canvas>
        <div class="mt-3 space-y-1">
            @foreach($expenseByCategory as $item)
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-600">{{ $item->category }}</span>
                <span class="font-medium text-gray-800">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Bottom Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

    {{-- Siswa Nunggak --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Siswa Belum Lunas</h3>
        @if($debtors->isEmpty())
            <div class="text-center py-6 text-gray-400 text-sm">
                <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Semua siswa sudah lunas!
            </div>
        @else
            <div class="space-y-2">
                @foreach($debtors as $debtor)
                <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-600 text-xs font-bold">
                            {{ substr($debtor['name'], 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $debtor['name'] }}</p>
                            <p class="text-xs text-gray-400">{{ $debtor['unpaid'] }} minggu belum bayar</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-red-600">Rp {{ number_format($debtor['amount'], 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
            <a href="{{ route('cash-payments.index') }}" class="mt-3 inline-block text-xs text-indigo-600 hover:underline">
                Lihat semua →
            </a>
        @endif
    </div>

    {{-- Transaksi Terakhir --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Transaksi Terakhir</h3>
        <div class="space-y-2">
            @foreach($recentIncomes as $income)
            <div class="flex items-center justify-between py-2 border-b border-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 max-w-xs truncate">{{ $income->title }}</p>
                        <p class="text-xs text-gray-400">{{ $income->income_date->format('d M Y') }}</p>
                    </div>
                </div>
                <span class="text-sm font-semibold text-emerald-600">+Rp {{ number_format($income->amount, 0, ',', '.') }}</span>
            </div>
            @endforeach

            @foreach($recentExpenses as $expense)
            <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 max-w-xs truncate">{{ $expense->title }}</p>
                        <p class="text-xs text-gray-400">{{ $expense->expense_date->format('d M Y') }}</p>
                    </div>
                </div>
                <span class="text-sm font-semibold text-red-600">-Rp {{ number_format($expense->amount, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Weekly Bar Chart
const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
new Chart(weeklyCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($weeklyStats->pluck('label')) !!},
        datasets: [
            {
                label: 'Sudah Bayar',
                data: {!! json_encode($weeklyStats->pluck('paid')) !!},
                backgroundColor: 'rgba(99,102,241,0.85)',
                borderRadius: 6,
            },
            {
                label: 'Belum Bayar',
                data: {!! json_encode($weeklyStats->pluck('unpaid')) !!},
                backgroundColor: 'rgba(239,68,68,0.6)',
                borderRadius: 6,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 11 } } }
        },
        scales: {
            y: { beginAtZero: true, max: 24, ticks: { stepSize: 4, font: { size: 11 } }, grid: { color: '#f3f4f6' } },
            x: { ticks: { font: { size: 11 } }, grid: { display: false } }
        }
    }
});

// Category Doughnut Chart
const catCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(catCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($expenseByCategory->pluck('category')) !!},
        datasets: [{
            data: {!! json_encode($expenseByCategory->pluck('total')) !!},
            backgroundColor: ['#6366f1','#10b981','#f59e0b','#ec4899','#94a3b8'],
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
@endpush
