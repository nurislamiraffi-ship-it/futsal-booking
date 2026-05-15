import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'neon-green': '#39FF14',
                'deep-slate': '#121212',
                'premium-black': '#0A0A0A',
                'futsal-neon': '#39FF14', // keeping for compatibility
                'futsal-dark': '#0F172A',
                'futsal-slate': '#1E293B',
            },
        },
    },
    plugins: [forms],
};
