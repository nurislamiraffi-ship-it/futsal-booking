@extends('layouts.app')

@section('title', 'Pembayaran - Futsal Booking')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center">
        <a href="{{ route('user.dashboard') }}" class="text-green-600 hover:text-green-800 mr-4 font-bold">&larr; Kembali</a>
        <h2 class="text-3xl font-bold text-gray-900 border-b-4 border-green-500 inline-block pb-2">Upload Bukti Pembayaran</h2>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="p-6 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Detail Booking ID: #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h3>
                <p class="text-gray-500 text-sm mt-1">Status: <span class="text-yellow-600 font-semibold">{{ $booking->status }}</span></p>
            </div>
            <div class="text-right">
                <p class="text-gray-500 text-sm">Total Tagihan</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
            </div>
        </div>
        
        <div class="p-6">
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-md">
                <h4 class="font-bold text-blue-800 mb-2">Instruksi Pembayaran:</h4>
                <p class="text-blue-700 text-sm mb-2">Silakan transfer sesuai <strong>Total Tagihan</strong> ke salah satu rekening berikut:</p>
                <ul class="list-disc pl-5 text-sm text-blue-700 space-y-1 font-mono">
                    <li>BRI: 000501212346507 a.n Diva safitri</li>
                    <li>SEA BANK: 901103419740 a.n Raffi Nur Islami</li>
                    <li>Gopay/OVO/Dana: 082113725420 a.n Raffi Nur Islami</li>
                </ul>
            </div>

            <form action="{{ route('user.pembayaran.store', $booking->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer (JPG/PNG)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                    <span>Pilih file</span>
                                    <input id="file-upload" name="proof_image" type="file" class="sr-only" required accept="image/*">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                        </div>
                    </div>
                    @error('proof_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-md transition shadow-md w-full sm:w-auto">
                        Kirim Bukti Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
