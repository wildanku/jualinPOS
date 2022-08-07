const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Lato', ...defaultTheme.fontFamily.sans],
            },
        }, 
    },

    plugins: [
        require('@tailwindcss/forms'),
        require("daisyui")
    ],

    daisyui: {
        themes: [
            {
                mytheme: {
                    "primary": "#379bd8",
                    "secondary": "#007EBD",
                    "accent": "#F8860D",
                    "neutral": "#1F2937",
                    "base-100": "#FFFFFF",
                    "info": "#3ABFF8",           
                    "success": "#36D399",
                    "warning": "#FBBD23",    
                    "error": "#F87272",
                },
            },
        ],
    },
};
