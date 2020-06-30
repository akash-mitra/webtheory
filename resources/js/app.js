require('./bootstrap');
require('./util.js');

// add vue, vueRouter
import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// add vue components
Vue.component('t-loader', require('./ui/TensorLoader.vue').default);
Vue.component('t-button', require('./ui/TensorButton.vue').default);
Vue.component('t-toggle', require('./ui/TensorToggle.vue').default);
Vue.component('t-error-message', require('./ui/TensorInputError.vue').default);
Vue.component('t-modal', require('./ui/TensorModal.vue').default);


// define the route files for the vue-router
import routes from './routes.js';
const router = new VueRouter(routes);


// finally create the vue app
let app = new Vue({
    el: '#app',
    router: router,
    data: {
        authUser: null,
        showDropdownMenu: false,
    },

    created() {
        if (this.authUser === null) {
            window.axios.get('/api/check').then ((response) => {
                // console.log(response.data)
                this.authUser = response.data
            });
        }
    },


    methods: {

        hideOverlayMenu (e) {
            if(e.target.id != 'auth-user-avatar') this.showDropdownMenu = false;
        }
    }
})
