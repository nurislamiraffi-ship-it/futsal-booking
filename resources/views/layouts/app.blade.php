<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Futsal Booking System')</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#16a34a">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Check local storage or system preference
        if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-premium-black text-gray-800 dark:text-gray-100 font-sans antialiased transition-colors duration-300" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }">

    <!-- Navbar -->
    <nav class="bg-green-600 dark:bg-deep-slate text-white shadow-lg border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold italic tracking-wider flex items-center">
                        <span class="text-white dark:text-neon-green mr-2">⚽</span> RaffiDiva Futsal
                    </a>
                </div>
                <div class="hidden md:flex space-x-4 items-center">
                    <a href="{{ route('home') }}" class="hover:text-green-200 dark:hover:text-neon-green transition">Home</a>
                    <a href="{{ route('sparring.index') }}" class="hover:text-green-200 dark:hover:text-neon-green transition flex items-center">
                        Cari Lawan <span class="ml-1 bg-neon-green text-black text-[10px] px-1 rounded font-bold">HOT</span>
                    </a>
                    
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark')" 
                            class="p-2 rounded-full hover:bg-green-700 dark:hover:bg-gray-800 transition focus:outline-none">
                        <template x-if="!darkMode">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </template>
                        <template x-if="darkMode">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z"></path></svg>
                        </template>
                    </button>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-green-200 transition">Admin Dashboard</a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="hover:text-green-200 transition">My Dashboard</a>
                        @endif
                        
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-1 hover:text-green-200 focus:outline-none">
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-deep-slate rounded-md shadow-lg py-1 z-50 text-gray-800 dark:text-gray-100 border dark:border-white/10">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-white/5">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-green-200 transition">Login</a>
                        <a href="{{ route('register') }}" class="bg-white text-green-600 px-4 py-2 rounded-md font-semibold hover:bg-gray-100 transition">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-green-100 dark:bg-green-500/10 border border-green-400 dark:border-green-500/20 text-green-700 dark:text-green-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-red-100 dark:bg-red-500/10 border border-red-400 dark:border-red-500/20 text-red-700 dark:text-red-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-premium-black border-t border-gray-200 dark:border-white/5 text-center py-8 mt-12">
        <p class="text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} RaffiDiva Futsal. Built with ❤️ for athletes.</p>
    </footer>

</body>
</html>
