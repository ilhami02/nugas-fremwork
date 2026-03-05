import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                campus: {
                    blue: '#0e4b6d',   // primary
                    'blue-d': '#0a3a55',  // darker blue (hover)
                    orange: '#ee9b11',   // accent
                    'orange-l': '#f0a928',// lighter orange (hover)
                    gray: '#c7c7c5',   // muted / border
                    dark: '#1f1a17',   // text / near-black
                },
            },
        },
    },

    plugins: [forms],
};
