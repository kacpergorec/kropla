/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
        "./templates/*.html.twig",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#2d0efe',
                secondary: '#2aff81',
                third: '#ff7800',
                darkgray: '#13121d',
            },
            fontFamily: {
                'sans': ['Inter'],
            },
        },
    },
    plugins: [],
}
