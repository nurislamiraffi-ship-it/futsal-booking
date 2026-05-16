@extends('layouts.app')

@section('title', 'Edit Lapangan - Admin Futsal Booking')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-10 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.lapangan.index') }}" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-gray-400 hover:bg-futsal-primary hover:text-white transition mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Edit <span class="text-futsal-primary dark:text-futsal-accent font-black tracking-normal">Lapangan</span></h2>
        </div>
        <div class="h-1 w-20 bg-futsal-accent hidden md:block rounded-full"></div>
    </div>

    <div class="bg-white dark:bg-futsal-card rounded-3xl shadow-xl overflow-hidden border border-slate-100 dark:border-slate-800">
        <form action="{{ route('admin.lapangan.update', $lapangan->id) }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2">Nama Lapangan</label>
                    <input type="text" name="name" value="{{ $lapangan->name }}" required 
                        class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-black focus:border-futsal-primary dark:focus:border-futsal-accent focus:ring-0 transition-all outline-none">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2">Harga per Jam (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 font-black">Rp</span>
                        <input type="number" name="price_per_hour" value="{{ $lapangan->price_per_hour }}" required 
                            class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-2xl pl-14 pr-6 py-4 text-slate-900 dark:text-white font-black focus:border-futsal-primary dark:focus:border-futsal-accent focus:ring-0 transition-all outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-2">Deskripsi</label>
                    <textarea name="description" required rows="4" 
                        class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-6 py-4 text-slate-900 dark:text-white font-black focus:border-futsal-primary dark:focus:border-futsal-accent focus:ring-0 transition-all outline-none resize-none">{{ $lapangan->description }}</textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-4">Foto Lapangan</label>
                    
                    <div class="flex flex-col md:flex-row gap-6 items-start md:items-end">
                        @if($lapangan->image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $lapangan->image) }}" class="h-40 w-40 object-cover rounded-2xl border-4 border-slate-100 dark:border-slate-800 shadow-lg group-hover:scale-105 transition-transform duration-300" alt="{{ $lapangan->name }}">
                                <div class="mt-4 flex items-center bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-xl border border-red-100 dark:border-red-900/30">
                                    <input type="checkbox" name="remove_image" id="remove_image" value="1" class="rounded border-slate-300 dark:border-slate-700 text-red-600 focus:ring-red-500 h-4 w-4 bg-transparent">
                                    <label for="remove_image" class="ml-2 text-[10px] font-black text-red-600 uppercase tracking-widest cursor-pointer">Hapus Foto</label>
                                </div>
                            </div>
                        @endif
                        
                        <div class="flex-1 w-full">
                            <div class="relative group">
                                <input type="file" name="image" accept="image/*" 
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 border-dashed rounded-2xl p-6 flex flex-col items-center justify-center group-hover:border-futsal-accent/50 transition-colors">
                                    <svg class="w-8 h-8 text-slate-300 dark:text-slate-700 mb-2 group-hover:text-futsal-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest">Pilih Foto Baru</span>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 dark:text-gray-600 font-bold mt-2 uppercase tracking-tight italic">Biarkan kosong jika tidak ingin mengubah foto.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-800 flex justify-center md:justify-end">
                <button type="submit" class="w-full md:w-auto bg-futsal-primary dark:bg-futsal-accent text-white dark:text-black font-black py-4 px-12 rounded-2xl transition transform hover:scale-105 shadow-xl shadow-futsal-primary/20 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
