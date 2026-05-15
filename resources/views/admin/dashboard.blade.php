@extends('layouts.app')

@section('title', 'Admin Dashboard - Futsal Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 border-b-4 border-green-500 inline-block pb-2">Admin Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-futsal-slate p-6 rounded-xl shadow-md border-l-4 border-green-500">
            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-2">Total Lapangan</h3>
            <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $totalLapangan }}</p>
            <a href="{{ route('admin.lapangan.index') }}" class="text-sm text-green-600 dark:text-futsal-neon hover:underline mt-2 inline-block">Kelola Lapangan &rarr;</a>
        </div>
        <div class="bg-white dark:bg-futsal-slate p-6 rounded-xl shadow-md border-l-4 border-blue-500">
            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-2">Total Jadwal</h3>
            <p class="text-4xl font-bold text-gray-900 dark:text-white">Manage</p>
            <a href="{{ route('admin.jadwal.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline mt-2 inline-block">Kelola Jadwal &rarr;</a>
        </div>
        <div class="bg-white dark:bg-futsal-slate p-6 rounded-xl shadow-md border-l-4 border-purple-500">
            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-2">Total Booking</h3>
            <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $totalBookings }}</p>
            <a href="{{ route('admin.booking.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:underline mt-2 inline-block">Kelola Booking &rarr;</a>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white dark:bg-futsal-slate p-6 rounded-xl shadow-md">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Statistik Booking (7 Hari Terakhir)</h3>
            <canvas id="bookingChart" height="200"></canvas>
        </div>
        <div class="bg-white dark:bg-futsal-slate p-6 rounded-xl shadow-md">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Pendapatan (7 Hari Terakhir)</h3>
            <canvas id="revenueChart" height="200"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-futsal-slate rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Booking Terbaru</h3>
            <a href="{{ route('admin.booking.index') }}" class="text-sm text-green-600 dark:text-futsal-neon hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lapangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-futsal-slate divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $booking->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $booking->lapangan->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
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
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada booking terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($labels) !!};
    
    // Booking Chart
    const bookingCtx = document.getElementById('bookingChart').getContext('2d');
    new Chart(bookingCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Booking',
                data: {!! json_encode($bookingData) !!},
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($revenueData) !!},
                backgroundColor: '#8B5CF6',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
