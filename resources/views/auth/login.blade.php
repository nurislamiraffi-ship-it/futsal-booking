@extends('layouts.app')

@section('title', 'Login - Futsal Booking')

@section('content')
<div class="min-h-[90vh] flex flex-col">
    <!-- Top Decorative Header -->
    <div class="h-48 bg-futsal-primary w-full flex items-center justify-center">
        <h1 class="text-white text-3xl font-black italic tracking-wider flex items-center gap-3">
            <span class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">⚽</span>
            RaffiDiva Futsal
        </h1>
    </div>

    <!-- Login Card Container -->
    <div class="flex-grow flex items-start justify-center px-4 -mt-24 pb-12">
        <div class="max-w-md w-full bg-white p-10 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-slate-100">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-black text-slate-900 tracking-tight">
                    Sign in <span class="text-futsal-accent font-black tracking-normal">ke Akun Anda</span>
                </h2>
                <p class="text-slate-500 mt-2 font-medium">Selamat datang kembali!</p>
            </div>
            
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email-address" class="block text-sm font-bold text-slate-700 mb-1 ml-1">Email</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required 
                            class="appearance-none rounded-2xl relative block w-full px-5 py-4 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-futsal-accent focus:border-transparent transition-all sm:text-sm bg-slate-50/50" 
                            placeholder="nama@email.com" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-1 ml-1">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                            class="appearance-none rounded-2xl relative block w-full px-5 py-4 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-futsal-accent focus:border-transparent transition-all sm:text-sm bg-slate-50/50" 
                            placeholder="••••••••">
                    </div>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 text-sm p-4 rounded-xl text-center font-medium border border-red-100">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="pt-2">
                    <button type="submit" class="group relative w-full flex justify-center py-4 px-6 border border-transparent text-lg font-black rounded-2xl text-black bg-futsal-accent hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-futsal-accent transition shadow-lg shadow-green-500/20">
                        Sign in
                    </button>
                </div>
                
                <div class="text-center text-slate-600 font-medium">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-futsal-primary font-black hover:underline ml-1">Daftar di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
