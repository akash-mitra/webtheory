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


// define the route files for the vue-router
import routes from './routes.js';
const router = new VueRouter(routes);
import { loginValid, isProtected, removeLocalCredential, getLocalUser } from './auth.js';



// check for authentication status before navigation
router.beforeEach((route, from, next) => {

    if (isProtected(route)) {

        if(loginValid()) {
            next();
        }
        else {
            // if login is not valid, ask to login explicitly
            next({path: "/app/login", query: { redirect: route.fullPath }});
        }

    } else {
        // this route does not require auth
        // but make sure to always call next()
        next();
    }
});


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
            this.authUser = getLocalUser()
        }
    },


    methods: {

        onUserLogin (user) { this.authUser = user },

        logout () {
            let p = this

            util.confirm('Logout?', 'Do you want to logout now?', function () {

                removeLocalCredential()

                p.authUser = null

                window.axios.post('/api/logout')
                    .then(r => { console.log(r) })
                    .catch(e => { console.log(e) })

                p.$router.push('/app/login')

            })

        }
    }
})
