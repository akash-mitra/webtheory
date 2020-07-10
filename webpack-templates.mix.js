/**
 * THIS IS THE MIX FILE FOR COMPILING TAILWIND CSS USED IN TEMPLATES
 */

const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')('./tailwind.config.js')
const purgecss = require('@fullhuman/postcss-purgecss')

const postCssPluginsFrontEnd = [tailwindcss]

const tailwindClassExtractor = function (content) {
    return content.match(/[\w-/:]+(?<!:)/g) || []
}

/**
 * While using the purgeCss plugin to remove unused css classes,
 * we must specify where should purgeCss look to find out current
 * css uses.
 * Since we generate 2 different css files for front and backend,
 * we must specify 2 different locations to search for css uses.
 */

const templateScanPaths = [
    './resources/views/active/*.php',
    './resources/views/modules/*.php',
    './resources/sass/typography.scss',
    './resources/js/frontend/modules/*.vue',
    './resources/js/frontend/pages/*.vue',
    './resources/js/frontend/users/*.vue',
]

// frontend
postCssPluginsFrontEnd.push(
    purgecss({
        content: templateScanPaths,
        defaultExtractor: tailwindClassExtractor,
    })
)

/*
 * This is to circumvent an odd browser cache issue
 * when using dynamic import.
 * Refer this issue - https://github.com/JeffreyWay/laravel-mix/issues/2064#issuecomment-590296532
 */
// mix.webpackConfig({
//   output: {
//     chunkFilename: "js/chunks/[id].chunk.[chunkhash].js"
//   }
// });

/*
 * Since we will be using CSS preprocessors (SASS), we will use
 * Laravel Mix's options method to add tailwindcss as a PostCSS
 * plugin.
 * Also, due to an unresolved issue witn Mix's dependecies, we
 * will need to disable processCssUrls. For details, refer -
 * https://tailwindcss.com/docs/installation#laravel-mix
 */
mix.options({ processCssUrls: false })

mix.sass('resources/sass/style.scss', 'public/css', {}, postCssPluginsFrontEnd)

// This is added to give webpack the ability to do dynamic import
mix.babelConfig({ plugins: ['@babel/plugin-syntax-dynamic-import'] })
