
/**
 * Sweetalert plugins
 */
window.Swal = require('sweetalert2');


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.axios.defaults.withCredentials = true;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.get('/api/airlock/csrf-cookie').then ((response) => {});
window.axios.get('/api/check').then ((response) => {
    if (Object.keys(response.data).length != 0 && response.data.constructor === Object) {
        
        if (['admin', 'author'].indexOf(response.data.role) === -1) {
            util.notifyError ('Unauthorised', "Only Admins can access this page.")
            return this.$router.replace('/')
        }

        let authUser = response.data

        window.localStorage.setItem('userIsAuthenticated', true)
        window.localStorage.setItem('lastLoginAt', (new Date()).getTime())
        window.localStorage.setItem('authUser', JSON.stringify(authUser))

        // this.$emit('login', authUser)
    }
});


/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.token = token.content;
} else {
    console.error('CSRF token not found');
}
