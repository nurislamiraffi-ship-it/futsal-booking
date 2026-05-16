@extends('layouts.app')

@section('title', 'Pembayaran - Futsal Booking')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-10 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('user.dashboard') }}" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-gray-400 hover:bg-futsal-primary hover:text-white transition mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Upload <span class="text-futsal-primary dark:text-futsal-accent">Pembayaran</span></h2>
        </div>
        <span class="text-xs font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full">ID #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
    </div>

    <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl overflow-hidden border border-slate-100 dark:border-slate-800">
        <div class="p-8 bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white">{{ $booking->lapangan->name }}</h3>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs font-bold text-slate-500 dark:text-gray-400 uppercase tracking-tighter">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                    <span class="text-xs font-black text-futsal-primary dark:text-futsal-accent">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</span>
                </div>
            </div>
            <div class="text-left md:text-right">
                <p class="text-xs font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1">Total Tagihan</p>
                <p class="text-3xl font-black text-futsal-primary dark:text-futsal-accent leading-none">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
            </div>
        </div>
        
        <div class="p-8">
            <div class="mb-10 bg-futsal-primary/5 dark:bg-futsal-accent/5 border-l-4 border-futsal-primary dark:border-futsal-accent p-6 rounded-r-2xl">
                <h4 class="font-black text-futsal-primary dark:text-futsal-accent mb-4 uppercase tracking-widest text-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Instruksi Pembayaran
                </h4>
                <p class="text-slate-600 dark:text-gray-300 text-sm mb-4 font-medium">Silakan transfer sesuai <strong>Total Tagihan</strong> ke salah satu rekening berikut:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white dark:bg-slate-900/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800">
                        <p class="text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1">BANK BRI</p>
                        <p class="text-sm font-black text-slate-800 dark:text-white tracking-wider">000501212346507</p>
                        <p class="text-xs text-slate-500 dark:text-gray-400 font-medium mt-1">a.n Diva Safitri</p>
                    </div>
                    <div class="bg-white dark:bg-slate-900/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800">
                        <p class="text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1">SEA BANK</p>
                        <p class="text-sm font-black text-slate-800 dark:text-white tracking-wider">901103419740</p>
                        <p class="text-xs text-slate-500 dark:text-gray-400 font-medium mt-1">a.n Raffi Nur Islami</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('user.pembayaran.store', $booking->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-10">
                    <label class="block text-sm font-black text-slate-700 dark:text-gray-300 mb-4 uppercase tracking-widest">Upload Bukti Transfer</label>
                    <div class="mt-1 flex justify-center px-8 pt-8 pb-10 border-2 border-slate-200 dark:border-slate-800 border-dashed rounded-3xl hover:border-futsal-accent/50 transition-colors group">
                        <div class="space-y-2 text-center">
                            <svg class="mx-auto h-16 w-16 text-slate-300 dark:text-slate-700 group-hover:text-futsal-accent transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 dark:text-gray-400 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-futsal-primary dark:bg-futsal-accent px-6 py-2 rounded-xl font-black text-white dark:text-black hover:opacity-80 transition focus-within:outline-none shadow-lg">
                                    <span>Pilih File</span>
                                    <input id="file-upload" name="proof_image" type="file" class="sr-only" required accept="image/*">
                                </label>
                            </div>
                            <p class="text-xs text-slate-400 dark:text-gray-600 font-medium">PNG, JPG, JPEG up to 2MB</p>
                        </div>
                    </div>
                    @error('proof_image')
                        <p class="text-red-500 text-[10px] font-black uppercase tracking-widest mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-center md:justify-end">
                    <button type="submit" class="w-full md:w-auto bg-futsal-accent hover:bg-green-400 text-black font-black py-4 px-12 rounded-2xl transition transform hover:scale-105 shadow-xl shadow-green-500/20 flex items-center justify-center gap-2">
                        Kirim Bukti Pembayaran
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
