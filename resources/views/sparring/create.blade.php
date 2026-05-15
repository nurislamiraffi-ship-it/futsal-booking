@extends('layouts.app')

@section('title', 'Buka Slot Sparring - Futsal Booking')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white dark:bg-deep-slate rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-white/5">
        <div class="bg-green-600 p-8 text-white text-center">
            <h2 class="text-3xl font-extrabold">Buka Slot Sparring</h2>
            <p class="mt-2 text-green-100">Cari lawan tanding untuk tim kamu dengan mudah.</p>
        </div>
        
        <form action="{{ route('sparring.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pilih Lapangan</label>
                    <select name="lapangan_id" class="w-full rounded-xl border-gray-200 dark:border-white/10 dark:bg-white/5 dark:text-white focus:ring-green-500 transition" required>
                        @foreach($lapangans as $lapangan)
                            <option value="{{ $lapangan->id }}">{{ $lapangan->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                    <input type="date" name="date" class="w-full rounded-xl border-gray-200 dark:border-white/10 dark:bg-white/5 dark:text-white focus:ring-green-500 transition" required min="{{ date('Y-m-d') }}">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Jam Mulai</label>
                    <input type="time" name="start_time" class="w-full rounded-xl border-gray-200 dark:border-white/10 dark:bg-white/5 dark:text-white focus:ring-green-500 transition" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Jam Selesai</label>
                    <input type="time" name="end_time" class="w-full rounded-xl border-gray-200 dark:border-white/10 dark:bg-white/5 dark:text-white focus:ring-green-500 transition" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" rows="4" class="w-full rounded-xl border-gray-200 dark:border-white/10 dark:bg-white/5 dark:text-white focus:ring-green-500 transition" placeholder="Contoh: Cari lawan level medioker, jam 8 malam."></textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-green-500/30 transition transform hover:-translate-y-1">
                    Publikasikan Slot Sparring
                </button>
                <p class="text-center text-xs text-gray-400 mt-4 italic">*Pastikan Anda sudah membooking lapangan tersebut secara terpisah jika ingin menjamin slot waktu.</p>
            </div>
        </form>
    </div>
</div>
@endsection
