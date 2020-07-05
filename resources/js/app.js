/*
 * This is the main JavaScript file for the
 * backend Admin Control Panel of WebTheory.
 */

// Load utility libraries
require('./bootstrap')
require('./util.js')

// Setup VueRouter and make it available globally
import routes from './routes.js'
import VueRouter from 'vue-router'
window.router = new VueRouter(routes)

// Setup Vue and make it available globally
import Vue from 'vue'
Vue.use(VueRouter)
window.Vue = Vue

// Add globally available common vue components
Vue.component('t-loader', require('./ui/TensorLoader.vue').default)
Vue.component('t-button', require('./ui/TensorButton.vue').default)
Vue.component('t-toggle', require('./ui/TensorToggle.vue').default)
Vue.component('t-error-message', require('./ui/TensorInputError.vue').default)
Vue.component('t-modal', require('./ui/TensorModal.vue').default)
