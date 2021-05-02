module.exports = {
    mode: 'jit',
    purge: [
        './resources/views/app.blade.php',
        './resources/js/components/*.vue',
        './resources/js/ui/*.vue',
        './resources/js/util.js',
    ],
    // darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
