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
            colors: {
                'futsal-green': {
                    DEFAULT: '#22c55e',
                    dark: '#4ade80',
                },
                'futsal-dark': '#0f172a',
                'futsal-primary': '#14532d', // Dark Green for Header
                'futsal-accent': '#22c55e',  // Neon Green
                'futsal-card': '#1e293b',    // Slate 800 for Cards
                'futsal-dark-bg': '#020617', // Slate 950 for Body
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
