@extends('layouts.app')

@section('title', 'Futsal Booking System - Home')

@section('content')
<!-- Hero Section -->
<div class="relative min-h-[80vh] flex items-center justify-center bg-futsal-dark-bg text-white overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1536122985607-4fea00b5276c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Futsal Court" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-b from-futsal-dark-bg/50 via-transparent to-futsal-dark-bg"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 flex flex-col items-center text-center">
        <div class="inline-block px-4 py-1.5 mb-6 rounded-full bg-green-500/10 border border-green-500/20 text-futsal-accent text-sm font-semibold tracking-wide uppercase">
            Platform Booking No. 1 di Indonesia
        </div>
        <h1 class="text-5xl md:text-7xl font-black tracking-tight mb-6 leading-tight">
            Main Futsal Makin <span class="text-futsal-accent drop-shadow-[0_0_15px_rgba(34,197,94,0.5)]">Gampang!</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-400 max-w-3xl mb-10 leading-relaxed">
            Booking lapangan futsal favoritmu secara online. Cek jadwal, pilih waktu, dan main tanpa ribet.
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('register') }}" class="bg-futsal-accent hover:bg-green-400 text-black font-black py-4 px-10 rounded-xl shadow-[0_0_20px_rgba(34,197,94,0.3)] transition transform hover:scale-105">Booking Sekarang</a>
            <a href="#lapangan" class="bg-white/5 backdrop-blur-md border border-white/10 hover:bg-white/10 text-white font-bold py-4 px-10 rounded-xl transition">Lihat Lapangan</a>
        </div>
    </div>
</div>

<!-- Pilihan Lapangan Section -->
<div id="lapangan" class="py-24 bg-futsal-dark-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-4 text-center md:text-left">
            <div>
                <h2 class="text-4xl font-black text-white mb-4">Pilihan <span class="text-futsal-accent">Lapangan</span></h2>
                <p class="text-gray-400 text-lg max-w-2xl">Pilih lapangan terbaik yang sesuai dengan kebutuhan tim kamu.</p>
            </div>
            <div class="h-1 w-24 bg-futsal-accent hidden md:block"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            @foreach($lapangans as $lapangan)
            <div class="group bg-futsal-card rounded-2xl overflow-hidden border border-slate-700/50 hover:border-futsal-accent/50 transition duration-500 shadow-2xl">
                <div class="h-72 bg-slate-900 flex items-center justify-center relative overflow-hidden">
                    @if($lapangan->image)
                        <img src="{{ asset('storage/' . $lapangan->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $lapangan->name }}">
                    @else
                        <div class="flex flex-col items-center text-center p-8">
                            <svg class="w-16 h-16 mb-4 text-futsal-accent/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-gray-500 font-medium">Foto {{ $lapangan->name }} Belum Tersedia</span>
                        </div>
                    @endif
                    <div class="absolute top-6 right-6 bg-futsal-accent text-black font-black px-4 py-1.5 rounded-lg shadow-lg z-10 text-sm">
                        Rp {{ number_format($lapangan->price_per_hour, 0, ',', '.') }} / Jam
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-futsal-card to-transparent opacity-60"></div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-white mb-3">{{ $lapangan->name }}</h3>
                    <p class="text-gray-400 mb-8 leading-relaxed line-clamp-2 italic">"{{ $lapangan->description }}"</p>
                    
                    @auth
                        @if(auth()->user()->role == 'user')
                            <a href="{{ route('user.booking.create', $lapangan->id) }}" class="block w-full text-center bg-futsal-accent hover:bg-green-400 text-black font-black py-3 rounded-xl transition shadow-lg">Booking Sekarang</a>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="block w-full text-center bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 rounded-xl transition">Dashboard Admin</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center bg-white/10 hover:bg-futsal-accent hover:text-black text-white font-bold py-3 rounded-xl transition border border-white/5">Login untuk Pesan</a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Jam Operasional & Testimoni -->
<div class="py-24 bg-slate-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Jam Operasional -->
        <div class="bg-futsal-card p-10 rounded-2xl border-t-4 border-futsal-accent shadow-2xl">
            <h3 class="text-2xl font-black mb-8 flex items-center text-white">
                <div class="w-10 h-10 rounded-full bg-futsal-accent/10 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-futsal-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                Jam Operasional
            </h3>
            <div class="space-y-6">
                <div class="flex justify-between items-center border-b border-slate-700/50 pb-4">
                    <span class="text-gray-400 font-medium uppercase tracking-wider text-sm">Senin - Jumat</span>
                    <span class="text-white font-black">08:00 - 23:00</span>
                </div>
                <div class="flex justify-between items-center border-b border-slate-700/50 pb-4">
                    <span class="text-gray-400 font-medium uppercase tracking-wider text-sm">Sabtu - Minggu</span>
                    <span class="text-white font-black">07:00 - 24:00</span>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="text-futsal-accent font-bold uppercase tracking-wider text-sm">Hari Libur Nasional</span>
                    <span class="bg-futsal-accent/20 text-futsal-accent px-3 py-1 rounded-md text-xs font-black uppercase">Tetap Buka</span>
                </div>
            </div>
        </div>

        <!-- Testimoni -->
        <div class="bg-futsal-primary p-10 rounded-2xl border-t-4 border-futsal-accent shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition duration-500">
                <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
            </div>
            <h3 class="text-2xl font-black mb-8 flex items-center text-white relative z-10">
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                Kata Mereka
            </h3>
            <div class="relative z-10">
                <p class="text-xl text-gray-100 italic leading-relaxed mb-8">
                    "Lapangan mantap, rumput sintetisnya empuk. Proses booking juga gampang banget, nggak perlu repot antre ke lokasi!"
                </p>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-futsal-accent/20 flex items-center justify-center font-black text-futsal-accent mr-4">RD</div>
                    <div>
                        <div class="font-black text-white text-lg">RaffiDiva</div>
                        <div class="text-white/60 text-sm">Pemain Setia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
