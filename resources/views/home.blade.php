@extends('layouts.app')

@section('title', 'Futsal Booking System - Home')

@section('content')
<!-- Hero Section -->
<div class="relative bg-black text-white overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1536122985607-4fea00b5276c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Futsal Court" class="w-full h-full object-cover opacity-40">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col items-center text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-4">
            Main Futsal Makin <span class="text-green-500">Gampang!</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mb-8">
            Booking lapangan futsal favoritmu secara online. Cek jadwal, pilih waktu, dan main tanpa ribet.
        </p>
        <div class="space-x-4">
            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-500 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">Booking Sekarang</a>
            <a href="#lapangan" class="bg-transparent border-2 border-white hover:bg-white hover:text-black text-white font-bold py-3 px-8 rounded-full shadow-lg transition">Lihat Lapangan</a>
        </div>
    </div>
</div>

<!-- Informasi Lapangan Section -->
<div id="lapangan" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 border-b-4 border-green-500 inline-block pb-2">Pilihan Lapangan</h2>
            <p class="mt-4 text-gray-600">Berbagai jenis lapangan futsal terbaik untuk pengalaman bermain maksimal.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($lapangans as $lapangan)
            <div class="bg-gray-50 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 border border-gray-200">
                <div class="h-64 bg-gray-300 flex items-center justify-center relative">
                    <!-- Placeholder for image -->
                    @if($lapangan->image)
                        <img src="{{ asset('storage/' . $lapangan->image) }}" class="w-full h-full object-cover" alt="{{ $lapangan->name }}">
                    @else
                        <span class="text-gray-500 flex flex-col items-center">
                            <svg class="w-12 h-12 mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Foto Lapangan
                        </span>
                    @endif
                    <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full font-bold shadow">
                        Rp {{ number_format($lapangan->price_per_hour, 0, ',', '.') }} / Jam
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $lapangan->name }}</h3>
                    <p class="text-gray-600 mb-4 h-12 overflow-hidden">{{ $lapangan->description }}</p>
                    @auth
                        @if(auth()->user()->role == 'user')
                            <a href="{{ route('user.booking.create', $lapangan->id) }}" class="block w-full text-center bg-green-600 text-white hover:bg-green-700 font-bold py-2 px-4 rounded transition shadow-sm">Pesan Lapangan Ini</a>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="block w-full text-center bg-gray-800 text-white hover:bg-black font-bold py-2 px-4 rounded transition">Dashboard Admin</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center bg-black text-white hover:bg-green-600 font-bold py-2 px-4 rounded transition">Pesan Lapangan Ini</a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Jam Operasional & Testimoni -->
<div class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Jam Operasional -->
        <div class="bg-white p-8 rounded-xl shadow-md border-t-4 border-green-500">
            <h3 class="text-2xl font-bold mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Jam Operasional
            </h3>
            <ul class="space-y-4 text-gray-700">
                <li class="flex justify-between border-b pb-2"><span>Senin - Jumat</span> <span class="font-bold">08:00 - 23:00</span></li>
                <li class="flex justify-between border-b pb-2"><span>Sabtu - Minggu</span> <span class="font-bold">07:00 - 24:00</span></li>
                <li class="flex justify-between pb-2 text-green-600 font-bold"><span>Hari Libur Nasional</span> <span>Tetap Buka</span></li>
            </ul>
        </div>

        <!-- Testimoni -->
        <div class="bg-black text-white p-8 rounded-xl shadow-md border-t-4 border-green-500">
            <h3 class="text-2xl font-bold mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                Kata Mereka
            </h3>
            <div class="italic text-gray-300 mb-4">
                "Lapangan mantap, rumput sintetisnya empuk. Proses booking juga gampang banget, nggak perlu repot antre ke lokasi!"
            </div>
            <div class="font-bold text-green-400">- RaffiDiva</div>
        </div>
    </div>
</div>
@endsection
