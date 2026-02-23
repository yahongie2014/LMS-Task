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
                sans: ['Roboto', 'Cairo', ...defaultTheme.fontFamily.sans],
                roboto: ['Roboto', 'sans-serif'],
                cairo: ['Cairo', 'sans-serif'],
            },
            colors: {
                primary: 'hsl(var(--primary-vibrant))',
                secondary: 'hsl(var(--secondary))',
            },
            borderRadius: {
                '3xl': '1.5rem',
                '4xl': '2rem',
            },
        },
    },

    plugins: [forms],
};
