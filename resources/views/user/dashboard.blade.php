@extends('layouts.app')

@section('title', 'My Dashboard - Futsal Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">Halo, <span class="text-futsal-primary dark:text-futsal-accent font-black tracking-normal">{{ auth()->user()->name }}!</span></h2>
            <p class="text-slate-500 dark:text-gray-400 mt-1 font-medium">Siap untuk main futsal hari ini? Cek jadwal dan booking sekarang.</p>
        </div>
        <div class="h-1 w-20 bg-futsal-accent hidden md:block rounded-full"></div>
    </div>

    <!-- Daftar Lapangan untuk Booking -->
    <div class="mb-16">
        <h3 class="text-xl font-black text-slate-900 dark:text-white mb-8 flex items-center">
            <div class="w-8 h-8 rounded-full bg-futsal-primary/10 dark:bg-futsal-accent/10 flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-futsal-primary dark:text-futsal-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            </div>
            Pesan Lapangan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($lapangans as $lapangan)
            <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden group hover:border-futsal-accent/50 transition-all duration-300">
                <div class="p-8">
                    <h4 class="text-2xl font-black text-slate-900 dark:text-white mb-3">{{ $lapangan->name }}</h4>
                    <p class="text-slate-500 dark:text-gray-400 text-sm mb-6 h-10 overflow-hidden italic">"{{ $lapangan->description }}"</p>
                    <div class="flex items-center justify-between mt-auto">
                        <span class="bg-futsal-primary/10 text-futsal-primary dark:bg-futsal-accent/10 dark:text-futsal-accent px-4 py-2 rounded-xl font-black text-sm">
                            Rp {{ number_format($lapangan->price_per_hour, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('user.booking.create', $lapangan->id) }}" class="text-sm font-black text-slate-900 dark:text-white hover:text-futsal-primary dark:hover:text-futsal-accent flex items-center gap-1 transition-all hover:gap-2">
                            Pilih Jadwal 
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Booking -->
    <div>
        <h3 class="text-xl font-black text-slate-900 dark:text-white mb-8 flex items-center">
            <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-slate-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            Riwayat Booking Saya
        </h3>
        <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                    <thead class="bg-slate-50/50 dark:bg-slate-900/50">
                        <tr>
                            <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Lapangan</th>
                            <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Waktu</th>
                            <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest text-center">Biaya</th>
                            <th class="px-8 py-5 text-center text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-right text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($myBookings as $booking)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                            <td class="px-8 py-6 whitespace-nowrap text-sm font-black text-slate-900 dark:text-white">{{ $booking->lapangan->name }}</td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                <div class="text-xs text-slate-500 dark:text-gray-500 font-medium">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-center text-sm font-black text-slate-900 dark:text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
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
                                @if($booking->status == 'Menunggu Pembayaran')
                                    <a href="{{ route('user.pembayaran.create', $booking->id) }}" class="inline-flex items-center gap-1 font-black text-futsal-primary dark:text-futsal-accent hover:underline">
                                        Upload Pembayaran
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    </a>
                                @elseif($booking->status == 'Diproses' && $booking->pembayaran)
                                    <span class="text-slate-400 dark:text-gray-500 text-xs italic font-medium">Menunggu konfirmasi admin</span>
                                @else
                                    <span class="text-slate-300 dark:text-gray-700">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-500 dark:text-gray-500 font-medium italic">Kamu belum memiliki riwayat booking.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
