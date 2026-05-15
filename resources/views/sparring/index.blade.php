@extends('layouts.app')

@section('title', 'Cari Lawan Sparring - Futsal Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Cari Lawan <span class="text-green-600 dark:text-neon-green">Sparring</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Temukan teman tanding atau buka slot sparring tim kamu.</p>
        </div>
        <a href="{{ route('sparring.create') }}" class="mt-4 md:mt-0 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold transition transform hover:scale-105 shadow-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buka Slot Sparring
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($sparrings as $sparring)
            <div class="bg-white dark:bg-deep-slate rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-white/5 hover:border-green-500/50 transition-all duration-300 group">
                <div class="relative h-48">
                    <img src="{{ $sparring->lapangan->image ? asset('storage/' . $sparring->lapangan->image) : 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&q=80&w=800' }}" 
                         alt="{{ $sparring->lapangan->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute top-4 right-4">
                        <span class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest {{ $sparring->status == 'Open' ? 'bg-green-500 text-white' : 'bg-blue-500 text-white' }}">
                            {{ $sparring->status }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-500/20 flex items-center justify-center text-green-600 dark:text-neon-green font-bold mr-3">
                            {{ strtoupper(substr($sparring->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">{{ $sparring->user->name }}</h4>
                            <p class="text-xs text-gray-500">Host Team</p>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $sparring->lapangan->name }}</h3>
                    
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($sparring->date)->format('l, d M Y') }}
                        </div>
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ substr($sparring->start_time, 0, 5) }} - {{ substr($sparring->end_time, 0, 5) }} WIB
                        </div>
                    </div>

                    @if($sparring->description)
                        <p class="text-sm text-gray-500 italic mb-6 line-clamp-2">"{{ $sparring->description }}"</p>
                    @endif

                    @if($sparring->status == 'Open' && $sparring->user_id !== auth()->id())
                        <form action="{{ route('sparring.join', $sparring->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-gray-900 dark:bg-white dark:text-black text-white py-3 rounded-xl font-bold hover:bg-green-600 dark:hover:bg-neon-green transition">
                                Join Sparring
                            </button>
                        </form>
                    @elseif($sparring->user_id === auth()->id())
                        <button disabled class="w-full bg-gray-100 dark:bg-white/5 text-gray-400 py-3 rounded-xl font-bold cursor-not-allowed">
                            Slot Anda
                        </button>
                    @else
                        <button disabled class="w-full bg-gray-100 dark:bg-white/5 text-gray-400 py-3 rounded-xl font-bold cursor-not-allowed">
                            Slot Penuh
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-gray-50 dark:bg-white/5 rounded-3xl border-2 border-dashed border-gray-200 dark:border-white/10">
                <p class="text-gray-500 text-lg">Belum ada slot sparring yang dibuka.</p>
                <a href="{{ route('sparring.create') }}" class="text-green-600 dark:text-neon-green font-bold hover:underline mt-2 inline-block">Jadilah yang pertama membuka slot!</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
