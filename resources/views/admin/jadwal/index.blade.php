@extends('layouts.app')

@section('title', 'Kelola Jadwal - Admin Futsal Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ showModal: false }">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">Kelola <span class="text-futsal-primary dark:text-futsal-accent font-black tracking-normal">Jadwal</span></h2>
            <p class="text-slate-500 dark:text-gray-400 mt-1 font-medium">Atur ketersediaan waktu untuk setiap lapangan.</p>
        </div>
        <button @click="showModal = true" class="bg-futsal-accent hover:bg-green-400 text-black font-black py-3 px-6 rounded-xl shadow-lg shadow-green-500/20 transition transform hover:scale-105 flex items-center gap-2 self-start md:self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            Tambah Jadwal
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                <thead class="bg-slate-50/50 dark:bg-slate-900/50">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Lapangan</th>
                        <th class="px-8 py-5 text-center text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-right text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($jadwals as $jadwal)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap text-sm font-black text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($jadwal->date)->format('d M Y') }}</td>
                        <td class="px-8 py-6 whitespace-nowrap text-sm font-bold text-slate-600 dark:text-gray-400">{{ substr($jadwal->start_time, 0, 5) }} - {{ substr($jadwal->end_time, 0, 5) }}</td>
                        <td class="px-8 py-6 whitespace-nowrap text-sm font-medium text-slate-600 dark:text-gray-400">{{ $jadwal->lapangan->name }}</td>
                        <td class="px-8 py-6 whitespace-nowrap text-center">
                            @if($jadwal->is_available)
                                <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-wider rounded-lg bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-futsal-accent text-center">Tersedia</span>
                            @else
                                <span class="px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-wider rounded-lg bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 text-center">Di-booking</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-black">
                            <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="text-futsal-primary dark:text-futsal-accent hover:underline mr-6">Edit</a>
                            <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-500 dark:text-gray-500 font-medium italic">Belum ada data jadwal.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" @click="showModal = false" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form action="{{ route('admin.jadwal.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Jadwal Baru</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pilih Lapangan</label>
                                <select name="lapangan_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-2 border">
                                    <option value="">-- Pilih Lapangan --</option>
                                    @foreach($lapangans as $lap)
                                        <option value="{{ $lap->id }}">{{ $lap->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" name="date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-2 border">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Mulai</label>
                                    <input type="time" name="start_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-2 border">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Selesai</label>
                                    <input type="time" name="end_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-2 border">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                        <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
