/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                primary:   { DEFAULT: '#1e40af', hover: '#1d3899', light: '#dbeafe' },
                secondary: { DEFAULT: '#7c3aed', hover: '#6d28d9', light: '#ede9fe' },
                success:   { DEFAULT: '#10b981', hover: '#059669', light: '#d1fae5' },
                warning:   { DEFAULT: '#f59e0b', hover: '#d97706', light: '#fef3c7' },
                danger:    { DEFAULT: '#ef4444', hover: '#dc2626', light: '#fee2e2' },
            },
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
            },
        },
    },
    plugins: [],
}