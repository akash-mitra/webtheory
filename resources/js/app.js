require('./bootstrap');
require('./util.js');

// import Vue from 'vue';
window.Vue = require('vue');



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
import upperFirst from 'lodash/upperFirst'
import camelCase from 'lodash/camelCase'

const requireComponent = require.context('./components', true, /\.vue$/i)

requireComponent.keys().forEach(fileName => {
    // Get component config
    const componentConfig = requireComponent(fileName)
    
    // Get PascalCase name of component
    const componentName = componentConfig.name || upperFirst(
        camelCase(
            // Strip the leading `./` and extension from the filename
            fileName.replace(/^\.\/(.*)\.\w+$/, '$1')
        )
    )

    // Register component globally
    Vue.component(
        componentName,
        // Look for the component options on `.default`, which will
        // exist if the component was exported with `export default`,
        // otherwise fall back to module's root.
        componentConfig.default || componentConfig
    )
})

