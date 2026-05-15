@extends('layouts.app')

@section('title', 'Edit Jadwal - Admin Futsal Booking')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center">
        <a href="{{ route('admin.jadwal.index') }}" class="text-green-600 hover:text-green-800 mr-4 font-bold">&larr; Kembali</a>
        <h2 class="text-3xl font-bold text-gray-900 border-b-4 border-green-500 inline-block pb-2">Edit Jadwal Lapangan</h2>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Lapangan</label>
                    <select name="lapangan_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3 border">
                        @foreach($lapangans as $lap)
                            <option value="{{ $lap->id }}" {{ $jadwal->lapangan_id == $lap->id ? 'selected' : '' }}>{{ $lap->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ $jadwal->date }}" required 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3 border">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Mulai</label>
                        <input type="time" name="start_time" value="{{ substr($jadwal->start_time, 0, 5) }}" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3 border">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Selesai</label>
                        <input type="time" name="end_time" value="{{ substr($jadwal->end_time, 0, 5) }}" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3 border">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status Ketersediaan</label>
                    <select name="is_available" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3 border">
                        <option value="1" {{ $jadwal->is_available ? 'selected' : '' }}>Tersedia</option>
                        <option value="0" {{ !$jadwal->is_available ? 'selected' : '' }}>Di-booking (Tidak Tersedia)</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-md transition shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
