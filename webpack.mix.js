const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss')


// this is added to give webpack the ability to do dynamic import
mix.babelConfig({
  plugins: ['@babel/plugin-syntax-dynamic-import'],
});


// CSS and JS files
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/typography.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
      });




// useful but buggy!
// mix.browserSync('https://localhost:3000/');