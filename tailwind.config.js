import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Instrument Sans", ...defaultTheme.fontFamily.sans],
                bebas: ["Bebas Neue", "sans-serif"],
            },
            keyframes: {
                'fade-in-down': {
                    '0%': {
                        opacity: '0',
                        transform: 'translateY(-20px)'
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateY(0)'
                    },
                },
            },
            colors: {
                primary: "#B91C1C", // Merah Gelap (Red-700)
                dark: "#111827", // Abu-abu Sangat Gelap (Gray-900)
                secondary: "#4B5563", // Abu-abu Medium (Gray-600)
            },
            animation: {
                'fade-in-down': 'fade-in-down 0.8s ease-out forwards',
            },
        },
    },

    plugins: [forms, typography],
};
