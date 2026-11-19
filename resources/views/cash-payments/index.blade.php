@extends('layouts.app')
@section('title', 'Absensi Kas')
@section('breadcrumb', 'Kelola pembayaran kas mingguan siswa')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="font-semibold text-gray-800">Matriks Pembayaran Kas</h2>
            <p class="text-xs text-gray-400 mt-0.5">Klik kotak untuk toggle status bayar/belum. Perubahan tersimpan otomatis.</p>
        </div>
        <div class="flex gap-3 text-xs">
            <div class="flex items-center gap-1.5">
                <div class="w-4 h-4 rounded bg-indigo-500"></div>
                <span class="text-gray-600">Sudah Bayar</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-4 h-4 rounded border-2 border-gray-200"></div>
                <span class="text-gray-600">Belum Bayar</span>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide w-8">#</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide min-w-[180px]">Nama Siswa</th>
                    @foreach($cashWeeks as $week)
                    <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide whitespace-nowrap">
                        Mg {{ $week->week_number }}
                        <span class="block font-normal text-gray-400 normal-case">Rp {{ number_format($week->amount, 0, ',', '.') }}</span>
                    </th>
                    @endforeach
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Lunas</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($students as $i => $student)
                @php
                    $paidCount = collect($paymentMap[$student->id])->filter()->count();
                    $totalWeeks = $cashWeeks->count();
                    $isFullPaid = $paidCount === $totalWeeks;
                @endphp
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-semibold
                                {{ $student->gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 leading-tight">{{ $student->name }}</p>
                                <p class="text-xs text-gray-400">{{ $student->nisn }}</p>
                            </div>
                        </div>
                    </td>

                    @foreach($cashWeeks as $week)
                    @php $isPaid = $paymentMap[$student->id][$week->id]; @endphp
                    <td class="px-3 py-3 text-center">
                        <button
                            onclick="togglePayment({{ $student->id }}, {{ $week->id }}, this)"
                            data-paid="{{ $isPaid ? '1' : '0' }}"
                            class="w-7 h-7 rounded-lg border-2 transition-all duration-150 flex items-center justify-center mx-auto
                                {{ $isPaid ? 'bg-indigo-500 border-indigo-500 text-white' : 'border-gray-200 text-transparent hover:border-indigo-300' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                    </td>
                    @endforeach

                    <td class="px-4 py-3 text-center">
                        @if($isFullPaid)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Lunas
                            </span>
                        @else
                            <span class="text-xs font-medium text-red-500">
                                {{ $totalWeeks - $paidCount }} minggu
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center">
                        @if($student->phone_number)
                        @php
                            $unpaidWeeks = $cashWeeks->filter(fn($w) => !$paymentMap[$student->id][$w->id]);
                            $totalUnpaid = $unpaidWeeks->count() * 5000;
                            $weekLabels = $unpaidWeeks->pluck('label')->join(', ');
                            $wa = '62' . ltrim($student->phone_number, '0');
                            $msg = urlencode("Halo {$student->name}, sekadar mengingatkan tunggakan uang kas kelas: {$weekLabels}. Total: Rp " . number_format($totalUnpaid, 0, ',', '.') . ". Mohon segera dibayar ya, terima kasih!");
                        @endphp
                        @if($totalUnpaid > 0)
                        <a href="https://wa.me/{{ $wa }}?text={{ $msg }}" target="_blank"
                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-green-500 hover:bg-green-600 text-white text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Tagih
                        </a>
                        @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-50 border-t border-gray-200">
                    <td colspan="2" class="px-4 py-3 text-xs font-semibold text-gray-600">Total Terkumpul</td>
                    @foreach($cashWeeks as $week)
                    @php
                        $paidInWeek = collect($paymentMap)->filter(fn($weeks) => $weeks[$week->id])->count();
                    @endphp
                    <td class="px-3 py-3 text-center text-xs font-semibold text-indigo-700">
                        Rp {{ number_format($paidInWeek * $week->amount, 0, ',', '.') }}
                        <span class="block text-gray-400 font-normal">({{ $paidInWeek }}/{{ $students->count() }})</span>
                    </td>
                    @endforeach
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePayment(studentId, weekId, btn) {
    const isPaid = btn.dataset.paid === '1';
    btn.disabled = true;
    btn.style.opacity = '0.5';

    fetch('{{ route("cash-payments.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ student_id: studentId, cash_week_id: weekId })
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.style.opacity = '1';
        if (data.status === 'paid') {
            btn.dataset.paid = '1';
            btn.className = btn.className.replace('border-gray-200 text-transparent hover:border-indigo-300', 'bg-indigo-500 border-indigo-500 text-white');
        } else {
            btn.dataset.paid = '0';
            btn.className = btn.className.replace('bg-indigo-500 border-indigo-500 text-white', 'border-gray-200 text-transparent hover:border-indigo-300');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.style.opacity = '1';
        alert('Gagal menyimpan, coba lagi.');
    });
}
</script>
@endpush
