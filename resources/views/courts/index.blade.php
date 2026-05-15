<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Lapangan Futsal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($courts as $court)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-2xl font-bold mb-2">{{ $court->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $court->description }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-lg font-semibold text-blue-600">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }} / Jam</span>
                                <a href="{{ route('bookings.create', $court) }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">Book Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($courts->isEmpty())
                <div class="text-center bg-white p-6 rounded shadow">
                    <p class="text-gray-500">Belum ada lapangan yang tersedia saat ini.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
