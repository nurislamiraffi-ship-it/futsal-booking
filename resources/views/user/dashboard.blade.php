@extends('layouts.app')

@section('title', 'My Dashboard - Futsal Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl font-bold text-gray-900 mb-8 border-b-4 border-green-500 inline-block pb-2">Halo, {{ auth()->user()->name }}!</h2>

    <!-- Daftar Lapangan untuk Booking -->
    <div class="mb-12">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Pesan Lapangan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lapangans as $lapangan)
            <div class="bg-white rounded-xl shadow border border-gray-200 flex flex-col justify-between">
                <div class="p-5">
                    <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $lapangan->name }}</h4>
                    <p class="text-gray-600 text-sm mb-4 h-10 overflow-hidden">{{ $lapangan->description }}</p>
                    <p class="text-green-600 font-bold">Rp {{ number_format($lapangan->price_per_hour, 0, ',', '.') }} / Jam</p>
                </div>
                <div class="bg-gray-50 px-5 py-3 border-t">
                    <a href="{{ route('user.booking.create', $lapangan->id) }}" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition">Pilih Jadwal</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Booking -->
    <div>
        <h3 class="text-xl font-bold text-gray-800 mb-4">Riwayat Booking Saya</h3>
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lapangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($myBookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $booking->lapangan->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }} <br>
                                <span class="text-xs">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($booking->status == 'Menunggu Pembayaran')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $booking->status }}</span>
                                @elseif($booking->status == 'Diproses')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $booking->status }}</span>
                                @elseif($booking->status == 'Disetujui')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $booking->status }}</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $booking->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($booking->status == 'Menunggu Pembayaran')
                                    <a href="{{ route('user.pembayaran.create', $booking->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">Upload Pembayaran</a>
                                @elseif($booking->status == 'Diproses' && $booking->pembayaran)
                                    <span class="text-gray-500 text-xs">Menunggu konfirmasi admin</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Kamu belum memiliki riwayat booking.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
