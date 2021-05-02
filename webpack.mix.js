/* Setup */
const VUE_VERSION = 2
const mix = require('laravel-mix')
const TAILWIND_CONFIG_FILE_APPS = './tailwind.config.app.js'
const TAILWIND_CONFIG_FILE_TEMPLATES = './tailwind.config.template.js'
const APP_JS_MAP = { 'resources/js/app.js': 'public/js', }
const APP_CSS_MAP = { 'resources/sass/app.css': 'public/css', }
const TEMPLATE_CSS_MAP = { 'resources/views/default/styles.css': 'public/css/default.css', }

/* Tasks */
enableDynamicImport()
compileApplicationJavaScriptFiles()
compileApplicationCSSFiles()
compileTemplateCSSFiles()

/* Functions */
function enableDynamicImport() {
    mix.babelConfig({
        plugins: ['@babel/plugin-syntax-dynamic-import'],
    }).webpackConfig({
        output: { chunkFilename: 'js/chunks/[id].chunk.[chunkhash].js', },
    })
}

function compileApplicationJavaScriptFiles() {
    for (let [src, output] of Object.entries(APP_JS_MAP)) {
        mix.js(src, output).vue({ version: VUE_VERSION })
    }
}

function compileApplicationCSSFiles() {
    for (let [src, output] of Object.entries(APP_CSS_MAP)) {
        mix.postCss(src, output, [require('tailwindcss')(TAILWIND_CONFIG_FILE_APPS)])
    }
}

function compileTemplateCSSFiles() {
    for (let [src, output] of Object.entries(TEMPLATE_CSS_MAP)) {
        mix.postCss(src, output, [require('tailwindcss')(TAILWIND_CONFIG_FILE_TEMPLATES)])
        if(mix.inProduction()) { mix.minify(output) }
    }
}
