@extends('layouts.app')

@section('title', 'Admin Dashboard - Futsal Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white border-b-4 border-green-500 inline-block pb-2">Admin Dashboard</h2>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-deep-slate p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 group hover:shadow-lg transition">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Lapangan</h3>
            <div class="flex items-end justify-between">
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalLapangan }}</p>
                <div class="p-2 bg-green-50 dark:bg-green-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-neon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <a href="{{ route('admin.lapangan.index') }}" class="text-xs text-green-600 dark:text-neon-green hover:underline mt-4 block">Kelola &rarr;</a>
        </div>
        
        <div class="bg-white dark:bg-deep-slate p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 group hover:shadow-lg transition">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Booking</h3>
            <div class="flex items-end justify-between">
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalBookings }}</p>
                <div class="p-2 bg-blue-50 dark:bg-blue-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <a href="{{ route('admin.booking.index') }}" class="text-xs text-blue-600 hover:underline mt-4 block">Kelola &rarr;</a>
        </div>

        <div class="bg-white dark:bg-deep-slate p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 group hover:shadow-lg transition">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Revenue (Bulan Ini)</h3>
            <div class="flex items-end justify-between">
                <p class="text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format(end($revenueData), 0, ',', '.') }}</p>
                <div class="p-2 bg-purple-50 dark:bg-purple-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Total dari booking disetujui</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 bg-white dark:bg-deep-slate p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5">
            <h3 class="text-lg font-bold mb-6 text-gray-900 dark:text-white">Tren Booking & Revenue</h3>
            <div class="h-80">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-deep-slate p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-white/5">
            <h3 class="text-lg font-bold mb-6 text-gray-900 dark:text-white">Popularitas Lapangan</h3>
            <div class="h-80 flex items-center justify-center">
                <canvas id="lapanganChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white dark:bg-deep-slate rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-white/5 bg-gray-50 dark:bg-white/5 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Booking Terbaru</h3>
            <a href="{{ route('admin.booking.index') }}" class="text-sm text-green-600 dark:text-neon-green hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-white/5">
                <thead class="bg-gray-50 dark:bg-white/5">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lapangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-deep-slate divide-y divide-gray-200 dark:divide-white/5">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $booking->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $booking->lapangan->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}<br>
                                <span class="text-xs font-bold text-gray-400">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusClasses = [
                                        'Menunggu Pembayaran' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-500',
                                        'Diproses' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/10 dark:text-blue-500',
                                        'Disetujui' => 'bg-green-100 text-green-800 dark:bg-green-500/10 dark:text-green-500',
                                        'Ditolak' => 'bg-red-100 text-red-800 dark:bg-red-500/10 dark:text-red-500',
                                    ];
                                    $class = $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $class }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 italic">Belum ada booking terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxTrend = document.getElementById('trendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Jumlah Booking',
                    data: @json($bookingCounts),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Revenue (Ribuan Rp)',
                    data: @json(array_map(fn($v) => $v / 1000, $revenueData)),
                    borderColor: '#8b5cf6',
                    backgroundColor: 'transparent',
                    borderDash: [5, 5],
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { color: document.documentElement.classList.contains('dark') ? '#fff' : '#666' } }
                },
                scales: {
                    y: { grid: { color: 'rgba(200, 200, 200, 0.1)' }, ticks: { color: '#666' } },
                    x: { grid: { display: false }, ticks: { color: '#666' } }
                }
            }
        });

        const ctxLapangan = document.getElementById('lapanganChart').getContext('2d');
        new Chart(ctxLapangan, {
            type: 'doughnut',
            data: {
                labels: @json($lapanganNames),
                datasets: [{
                    data: @json($lapanganBookingCounts),
                    backgroundColor: ['#10b981', '#3b82f6', '#8b5cf6', '#f59e0b', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { color: document.documentElement.classList.contains('dark') ? '#fff' : '#666' } }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection
