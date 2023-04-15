const colors = require('tailwindcss/colors')

const brandColors = {
    50: '#f8f1fe',
    100: '#f1e3fe',
    200: '#e3c7fc',
    300: '#d4acfb',
    400: '#c690f9',
    500: '#b874f8',
    600: '#935dc6',
    700: '#6e4695',
    800: '#4a2e63',
    900: '#251732',
    950: '#120c19',
}

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/ts/**/*.{html,js,svelte,ts}',
    ],

    theme: {
        extend: {
            colors: {
                primary: brandColors,
                secondary: colors.rose,
                tertiary: colors.amber,
            },
        },
        container: {
            center: true,
            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '4rem',
                xl: '5rem',
                '2xl': '6rem',
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
}
