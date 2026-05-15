@extends('layouts.app')

@section('title', 'Pesan Lapangan - Futsal Booking')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center">
        <a href="{{ route('user.dashboard') }}" class="text-green-600 hover:text-green-800 mr-4 font-bold">&larr; Kembali</a>
        <h2 class="text-3xl font-bold text-gray-900 border-b-4 border-green-500 inline-block pb-2">Pilih Jadwal {{ $lapangan->name }}</h2>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Informasi Lapangan</h3>
        <p class="text-gray-600 mb-2">{{ $lapangan->description }}</p>
        <p class="text-xl font-bold text-green-600">Rp {{ number_format($lapangan->price_per_hour, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/ Jam</span></p>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Jadwal Tersedia (Hari Ini & Mendatang)</h3>
        </div>
        <div class="p-6">
            @if($jadwals->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    Maaf, belum ada jadwal yang tersedia untuk lapangan ini.
                </div>
            @else
                <form action="{{ route('user.booking.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                        @foreach($jadwals as $jadwal)
                            <label class="cursor-pointer">
                                <input type="radio" name="jadwal_id" value="{{ $jadwal->id }}" class="peer sr-only" required>
                                <div class="rounded-lg border-2 border-gray-200 px-4 py-3 hover:bg-gray-50 peer-checked:border-green-500 peer-checked:bg-green-50 transition">
                                    <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($jadwal->date)->format('l, d M Y') }}</div>
                                    <div class="text-green-600 font-bold mt-1">{{ substr($jadwal->start_time, 0, 5) }} - {{ substr($jadwal->end_time, 0, 5) }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-md transition shadow-md">
                            Lanjut ke Pembayaran &rarr;
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
