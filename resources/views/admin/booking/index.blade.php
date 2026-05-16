@extends('layouts.app')

@section('title', 'Kelola Booking - Admin Futsal Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">Kelola <span class="text-futsal-primary dark:text-futsal-accent font-black tracking-normal">Booking</span></h2>
            <p class="text-slate-500 dark:text-gray-400 mt-1 font-medium">Verifikasi pembayaran dan kelola status reservasi lapangan.</p>
        </div>
        <div class="h-1 w-20 bg-futsal-accent hidden md:block rounded-full"></div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                <thead class="bg-slate-50/50 dark:bg-slate-900/50">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">User</th>
                        <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Lapangan & Waktu</th>
                        <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Biaya & Bukti</th>
                        <th class="px-8 py-5 text-center text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-right text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-black text-slate-600 dark:text-gray-400 mr-3">
                                    {{ substr($booking->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-900 dark:text-white">{{ $booking->user->name }}</div>
                                    <div class="text-xs text-slate-500 dark:text-gray-500 font-medium">{{ $booking->user->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm font-black text-slate-900 dark:text-white">{{ $booking->lapangan->name }}</div>
                            <div class="text-xs text-slate-500 dark:text-gray-500 font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                            <div class="text-xs text-futsal-primary dark:text-futsal-accent font-black">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm font-black text-slate-900 dark:text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                            @if($booking->pembayaran)
                                <a href="{{ asset('storage/' . $booking->pembayaran->proof_image) }}" target="_blank" class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-futsal-primary dark:text-futsal-accent hover:underline mt-1">
                                    Lihat Bukti
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            @else
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-gray-600 mt-1">Belum ada bukti</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-center">
                            @if($booking->status == 'Menunggu Pembayaran')
                                <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-wider rounded-lg bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">{{ $booking->status }}</span>
                            @elseif($booking->status == 'Diproses')
                                <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-wider rounded-lg bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">{{ $booking->status }}</span>
                            @elseif($booking->status == 'Disetujui')
                                <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-wider rounded-lg bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-futsal-accent">{{ $booking->status }}</span>
                            @else
                                <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-wider rounded-lg bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">{{ $booking->status }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right text-sm">
                            @if($booking->status == 'Diproses')
                                <div class="flex justify-end gap-3">
                                    <form action="{{ route('admin.booking.approve', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-futsal-primary dark:bg-futsal-accent text-white dark:text-black text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-lg hover:opacity-80 transition shadow-lg shadow-futsal-primary/20">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.booking.reject', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-lg hover:bg-red-600 transition shadow-lg shadow-red-500/20">Tolak</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-slate-300 dark:text-gray-700 font-black">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-500 dark:text-gray-500 font-medium italic">Belum ada data booking.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
