@extends('layouts.app')

@section('title', 'Edit Jadwal - Admin Futsal Booking')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-10 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.jadwal.index') }}" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-gray-400 hover:bg-futsal-primary hover:text-white transition mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Edit <span class="text-futsal-primary dark:text-futsal-accent font-black tracking-normal">Jadwal</span></h2>
        </div>
        <div class="h-1 w-20 bg-futsal-accent hidden md:block rounded-full"></div>
    </div>

    <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl overflow-hidden border border-slate-100 dark:border-slate-800">
        <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST" class="p-8 md:p-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2">Pilih Lapangan</label>
                    <div class="relative">
                        <select name="lapangan_id" required class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-black focus:border-futsal-primary dark:focus:border-futsal-accent focus:ring-0 transition-all outline-none appearance-none">
                            @foreach($lapangans as $lap)
                                <option value="{{ $lap->id }}" {{ $jadwal->lapangan_id == $lap->id ? 'selected' : '' }}>{{ $lap->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ $jadwal->date }}" required 
                        class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-black focus:border-futsal-primary dark:focus:border-futsal-accent focus:ring-0 transition-all outline-none">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2">Waktu Mulai</label>
                        <input type="time" name="start_time" value="{{ substr($jadwal->start_time, 0, 5) }}" required 
                            class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-black focus:border-futsal-primary dark:focus:border-futsal-accent focus:ring-0 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2">Waktu Selesai</label>
                        <input type="time" name="end_time" value="{{ substr($jadwal->end_time, 0, 5) }}" required 
                            class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-black focus:border-futsal-primary dark:focus:border-futsal-accent focus:ring-0 transition-all outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2">Status Ketersediaan</label>
                    <div class="relative">
                        <select name="is_available" required class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-black focus:border-futsal-primary dark:focus:border-futsal-accent focus:ring-0 transition-all outline-none appearance-none">
                            <option value="1" {{ $jadwal->is_available ? 'selected' : '' }}>Tersedia</option>
                            <option value="0" {{ !$jadwal->is_available ? 'selected' : '' }}>Di-booking (Tidak Tersedia)</option>
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-800 flex justify-center md:justify-end">
                <button type="submit" class="w-full md:w-auto bg-futsal-primary dark:bg-futsal-accent text-white dark:text-black font-black py-4 px-12 rounded-2xl transition transform hover:scale-105 shadow-xl shadow-futsal-primary/20 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
