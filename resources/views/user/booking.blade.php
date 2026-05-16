@extends('layouts.app')

@section('title', 'Pesan Lapangan - Futsal Booking')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-10 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('user.dashboard') }}" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-gray-400 hover:bg-futsal-primary hover:text-white transition mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Pilih <span class="text-futsal-primary dark:text-futsal-accent">Jadwal</span></h2>
        </div>
        <span class="text-sm font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest">{{ $lapangan->name }}</span>
    </div>

    <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl p-8 mb-10 border border-slate-100 dark:border-slate-800 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-5">
            <svg class="w-32 h-32 text-futsal-primary dark:text-futsal-accent" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
        </div>
        <h3 class="text-xl font-black text-slate-900 dark:text-white mb-4">Informasi Lapangan</h3>
        <p class="text-slate-500 dark:text-gray-400 mb-6 italic font-medium leading-relaxed">"{{ $lapangan->description }}"</p>
        <div class="flex items-center gap-2">
            <span class="text-3xl font-black text-futsal-primary dark:text-futsal-accent">Rp {{ number_format($lapangan->price_per_hour, 0, ',', '.') }}</span>
            <span class="text-sm font-bold text-slate-400 dark:text-gray-500 uppercase">/ Jam</span>
        </div>
    </div>

    <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl overflow-hidden border border-slate-100 dark:border-slate-800">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
            <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-wider">Jadwal Tersedia</h3>
        </div>
        <div class="p-8">
            @if($jadwals->isEmpty())
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-slate-500 dark:text-gray-500 font-medium italic text-lg">Maaf, belum ada jadwal yang tersedia untuk lapangan ini.</p>
                </div>
            @else
                <form action="{{ route('user.booking.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                        @foreach($jadwals as $jadwal)
                            <label class="group cursor-pointer">
                                <input type="radio" name="jadwal_id" value="{{ $jadwal->id }}" class="peer sr-only" required>
                                <div class="rounded-2xl border-2 border-slate-100 dark:border-slate-800 p-5 hover:border-futsal-primary/50 dark:hover:border-futsal-accent/50 peer-checked:border-futsal-primary dark:peer-checked:border-futsal-accent peer-checked:bg-futsal-primary/5 dark:peer-checked:bg-futsal-accent/5 transition-all duration-300 peer-checked:[&_svg]:block peer-checked:[&_.custom-circle]:bg-futsal-primary dark:peer-checked:[&_.custom-circle]:bg-futsal-accent peer-checked:[&_.custom-circle]:border-transparent">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="font-black text-slate-900 dark:text-white uppercase tracking-tight">{{ \Carbon\Carbon::parse($jadwal->date)->format('d M Y') }}</div>
                                        <div class="custom-circle w-6 h-6 rounded-full border-2 border-slate-200 dark:border-slate-700 flex items-center justify-center transition-all group-hover:scale-110">
                                            <svg class="w-3.5 h-3.5 text-white dark:text-black hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="text-futsal-primary dark:text-futsal-accent font-black text-xl">{{ substr($jadwal->start_time, 0, 5) }} - {{ substr($jadwal->end_time, 0, 5) }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex justify-center md:justify-end pt-6 border-t border-slate-100 dark:border-slate-800">
                        <button type="submit" class="w-full md:w-auto bg-futsal-accent hover:bg-green-400 text-black font-black py-4 px-10 rounded-2xl transition transform hover:scale-105 shadow-xl shadow-green-500/20 flex items-center justify-center gap-2">
                            Lanjut ke Pembayaran
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
