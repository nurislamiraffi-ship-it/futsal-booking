@extends('layouts.app')

@section('title', 'Edit Lapangan - Admin Futsal Booking')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center">
        <a href="{{ route('admin.lapangan.index') }}" class="text-green-600 hover:text-green-800 mr-4 font-bold">&larr; Kembali</a>
        <h2 class="text-3xl font-bold text-gray-900 border-b-4 border-green-500 inline-block pb-2">Edit Lapangan</h2>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <form action="{{ route('admin.lapangan.update', $lapangan->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lapangan</label>
                    <input type="text" name="name" value="{{ $lapangan->name }}" required 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3 border">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga per Jam (Rp)</label>
                    <input type="number" name="price_per_hour" value="{{ $lapangan->price_per_hour }}" required 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3 border">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" required rows="5" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3 border">{{ $lapangan->description }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Foto Lapangan</label>
                    @if($lapangan->image)
                        <div class="mb-4 flex items-end space-x-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                                <img src="{{ asset('storage/' . $lapangan->image) }}" class="h-32 w-32 object-cover rounded-lg border shadow-sm" alt="{{ $lapangan->name }}">
                            </div>
                            <div class="flex items-center mb-2">
                                <input type="checkbox" name="remove_image" id="remove_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500 h-4 w-4">
                                <label for="remove_image" class="ml-2 text-sm font-medium text-red-600">Hapus Foto Saat Ini</label>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" 
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, GIF. Maks: 2MB.</p>
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
