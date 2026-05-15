@extends('layouts.app')

@section('title', 'Admin Dashboard - Futsal Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl font-bold text-gray-900 mb-8 border-b-4 border-green-500 inline-block pb-2">Admin Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Total Lapangan</h3>
            <p class="text-4xl font-bold text-gray-900">{{ $totalLapangan }}</p>
            <a href="{{ route('admin.lapangan.index') }}" class="text-sm text-green-600 hover:underline mt-2 inline-block">Kelola Lapangan &rarr;</a>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Total Jadwal</h3>
            <p class="text-4xl font-bold text-gray-900">Manage</p>
            <a href="{{ route('admin.jadwal.index') }}" class="text-sm text-blue-600 hover:underline mt-2 inline-block">Kelola Jadwal &rarr;</a>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Total Booking</h3>
            <p class="text-4xl font-bold text-gray-900">{{ $totalBookings }}</p>
            <a href="{{ route('admin.booking.index') }}" class="text-sm text-purple-600 hover:underline mt-2 inline-block">Kelola Booking &rarr;</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Booking Terbaru</h3>
            <a href="{{ route('admin.booking.index') }}" class="text-sm text-green-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lapangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $booking->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->lapangan->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}<br>
                                <span class="text-xs">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</span>
                            </td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada booking terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
