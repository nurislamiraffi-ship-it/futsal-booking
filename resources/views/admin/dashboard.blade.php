@extends('layouts.app')

@section('title', 'Admin Dashboard - Futsal Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">Admin <span class="text-futsal-primary dark:text-futsal-accent font-black tracking-normal">Dashboard</span></h2>
            <p class="text-slate-500 dark:text-gray-400 mt-1 font-medium">Ringkasan aktivitas dan performa sistem hari ini.</p>
        </div>
        <div class="h-1 w-20 bg-futsal-accent hidden md:block rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white dark:bg-futsal-card p-8 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition duration-500">
                <svg class="w-20 h-20 text-futsal-primary dark:text-futsal-accent" fill="currentColor" viewBox="0 0 24 24"><path d="M19 5h-14c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-10c0-1.1-.9-2-2-2zm-7 10c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-500 dark:text-gray-400 uppercase tracking-widest mb-4">Total Lapangan</h3>
            <p class="text-5xl font-black text-slate-900 dark:text-white leading-none">{{ $totalLapangan }}</p>
            <a href="{{ route('admin.lapangan.index') }}" class="text-sm font-black text-futsal-primary dark:text-futsal-accent hover:underline mt-6 inline-flex items-center gap-1 transition-all hover:gap-2">
                Kelola Lapangan 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>
        
        <div class="bg-white dark:bg-futsal-card p-8 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition duration-500">
                <svg class="w-20 h-20 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1v-2h-2v2h-8v-2h-2v2h-1c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-14c0-1.1-.9-2-2-2zm0 16h-14v-11h14v11z"/></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-500 dark:text-gray-400 uppercase tracking-widest mb-4">Kelola Jadwal</h3>
            <p class="text-5xl font-black text-slate-900 dark:text-white leading-none">Manage</p>
            <a href="{{ route('admin.jadwal.index') }}" class="text-sm font-black text-blue-600 dark:text-blue-400 hover:underline mt-6 inline-flex items-center gap-1 transition-all hover:gap-2">
                Kelola Jadwal 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>

        <div class="bg-white dark:bg-futsal-card p-8 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition duration-500">
                <svg class="w-20 h-20 text-purple-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
            </div>
            <h3 class="text-sm font-bold text-slate-500 dark:text-gray-400 uppercase tracking-widest mb-4">Total Booking</h3>
            <p class="text-5xl font-black text-slate-900 dark:text-white leading-none">{{ $totalBookings }}</p>
            <a href="{{ route('admin.booking.index') }}" class="text-sm font-black text-purple-600 dark:text-purple-400 hover:underline mt-6 inline-flex items-center gap-1 transition-all hover:gap-2">
                Kelola Booking 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-12">
        <div class="bg-white dark:bg-futsal-card p-8 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800">
            <h3 class="text-xl font-black mb-6 text-slate-900 dark:text-white">Statistik Booking</h3>
            <canvas id="bookingChart"></canvas>
        </div>
        <div class="bg-white dark:bg-futsal-card p-8 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800">
            <h3 class="text-xl font-black mb-6 text-slate-900 dark:text-white">Pendapatan (Rp)</h3>
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all">
        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/50">
            <h3 class="text-xl font-black text-slate-900 dark:text-white">Booking Terbaru</h3>
            <a href="{{ route('admin.booking.index') }}" class="text-sm font-black text-futsal-primary dark:text-futsal-accent hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                <thead class="bg-slate-50/50 dark:bg-slate-900/50">
                    <tr>
                        <th class="px-8 py-4 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">User</th>
                        <th class="px-8 py-4 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Lapangan</th>
                        <th class="px-8 py-4 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-8 py-4 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-futsal-primary/10 flex items-center justify-center font-black text-futsal-primary dark:text-futsal-accent mr-3">
                                        {{ substr($booking->user->name, 0, 1) }}
                                    </div>
                                    <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $booking->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm font-medium text-slate-600 dark:text-gray-400">{{ $booking->lapangan->name }}</td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                <div class="text-xs text-slate-500 dark:text-gray-500 font-medium">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-center">
                                @if($booking->status == 'Menunggu Pembayaran')
                                    <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-wider rounded-lg bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">{{ $booking->status }}</span>
                                @elseif($booking->status == 'Diproses')
                                    <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-wider rounded-lg bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">{{ $booking->status }}</span>
                                @elseif($booking->status == 'Disetujui')
                                    <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-wider rounded-lg bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-futsal-accent">{{ $booking->status }}</span>
                                @else
                                    <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-wider rounded-lg bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">{{ $booking->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center text-slate-500 dark:text-gray-500 font-medium italic">Belum ada booking terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Booking Chart
    const ctxBooking = document.getElementById('bookingChart').getContext('2d');
    new Chart(ctxBooking, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Booking',
                data: {!! json_encode($bookingData) !!},
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(156, 163, 175, 0.1)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Revenue Chart
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($revenueData) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(156, 163, 175, 0.1)' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection
