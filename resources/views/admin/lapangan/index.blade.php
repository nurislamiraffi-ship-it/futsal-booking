@extends('layouts.app')

@section('title', 'Kelola Lapangan - Admin Futsal Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ showModal: false }">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">Kelola <span class="text-futsal-primary dark:text-futsal-accent font-black tracking-normal">Lapangan</span></h2>
            <p class="text-slate-500 dark:text-gray-400 mt-1 font-medium">Tambah, edit, atau hapus fasilitas lapangan futsal.</p>
        </div>
        <button @click="showModal = true" class="bg-futsal-accent hover:bg-green-400 text-black font-black py-3 px-6 rounded-xl shadow-lg shadow-green-500/20 transition transform hover:scale-105 flex items-center gap-2 self-start md:self-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            Tambah Lapangan
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                <thead class="bg-slate-50/50 dark:bg-slate-900/50">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Foto</th>
                        <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Nama Lapangan</th>
                        <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest text-center">Harga/Jam</th>
                        <th class="px-8 py-5 text-left text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Deskripsi</th>
                        <th class="px-8 py-5 text-right text-xs font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($lapangans as $lapangan)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap">
                            @if($lapangan->image)
                                <img src="{{ asset('storage/' . $lapangan->image) }}" class="h-16 w-16 object-cover rounded-2xl shadow-lg border-2 border-white dark:border-slate-700" alt="{{ $lapangan->name }}">
                            @else
                                <div class="h-16 w-16 bg-slate-100 dark:bg-slate-800 flex items-center justify-center rounded-2xl text-[10px] text-slate-400 dark:text-gray-500 font-bold uppercase tracking-tighter text-center px-2">No Image</div>
                            @endif
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-sm font-black text-slate-900 dark:text-white">{{ $lapangan->name }}</td>
                        <td class="px-8 py-6 whitespace-nowrap text-center">
                            <span class="bg-futsal-primary/10 text-futsal-primary dark:bg-futsal-accent/10 dark:text-futsal-accent px-3 py-1.5 rounded-lg font-black text-sm">
                                Rp {{ number_format($lapangan->price_per_hour, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-sm text-slate-500 dark:text-gray-400 max-w-xs truncate italic font-medium">"{{ $lapangan->description }}"</td>
                        <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-black">
                            <a href="{{ route('admin.lapangan.edit', $lapangan->id) }}" class="text-futsal-primary dark:text-futsal-accent hover:underline mr-6">Edit</a>
                            <form action="{{ route('admin.lapangan.destroy', $lapangan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-500 dark:text-gray-500 font-medium italic">Belum ada data lapangan.</td>
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
                <form action="{{ route('admin.lapangan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Lapangan Baru</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lapangan</label>
                                <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-2 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga per Jam (Rp)</label>
                                <input type="number" name="price_per_hour" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-2 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="description" required rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-2 border"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Foto Lapangan</label>
                                <input type="file" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maks: 2MB.</p>
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
