<template>

    <div class="absolute top-0 left-0 h-screen w-screen flex items-center justify-center bg-pattern">
        <div class="max-w-md mx-auto w-full bg-white border rounded-lg p-8 shadow-2xl">
            <form v-on:submit.prevent="attemptLogin">
                <h3 class="text-2xl flex items-center mb-6">
                    <img src="/images/tensor.svg" alt="WebTheory Home" class="h-16 w-16 mr-6">
                    WebTheory
                </h3>

                <div class="w-full ">
                    <label class="text-xs py-2 text-gray-700 uppercase" for="emailfield">Email</label>
                    <input type="email" v-model="email" name="Email" id="emailfield" ref="emailfield" class="px-2 py-1 w-full border bg-gray-200 rounded" autocomplete="username"/>
                </div>

                <div class="w-full mt-4">
                    <label class="text-xs py-2 text-gray-700 uppercase" for="pass_field">Password</label>
                    <input type="password" v-model="password" name="password" id="pass_field" class="px-2 py-1 w-full border bg-gray-200 rounded" autocomplete="current-password"/>
                </div>

                <input type="submit" class="mt-8 w-full bg-blue-500 text-white px-6 py-2 rounded shadow hover:bg-blue-800" value="Login Now">
            </form>

            <div v-if="social" class="flex flex-row justify-center font-semibold py-2 px-6 mt-8">
                <a href="javascript:void(0)" v-if="isFacebook" @click="onSocialLogin('facebook')" class="mr-6 facebook" title="Facebook">
                    <svg class="h-10 w-10 text-blue-500" viewBox="0 0 20 20">
                        <path fill="currentColor" d="M10,0.5c-5.247,0-9.5,4.253-9.5,9.5c0,5.247,4.253,9.5,9.5,9.5c5.247,0,9.5-4.253,9.5-9.5C19.5,4.753,15.247,0.5,10,0.5 M10,18.637c-4.77,0-8.636-3.867-8.636-8.637S5.23,1.364,10,1.364S18.637,5.23,18.637,10S14.77,18.637,10,18.637 M10.858,7.949c0-0.349,0.036-0.536,0.573-0.536h0.719v-1.3H11c-1.38,0-1.866,0.65-1.866,1.743v0.845h-0.86V10h0.86v3.887h1.723V10h1.149l0.152-1.299h-1.302L10.858,7.949z"></path>
                    </svg>
                </a>
                <a href="javascript:void(0)" v-if="isTwitter" @click="onSocialLogin('twitter')" class="mr-6 twitter" title="Twitter">
                    <svg class="h-10 w-10 text-blue-500" viewBox="0 0 20 20">
                        <path fill="currentColor" d="M14.467,6.707c-0.34,0.198-0.715,0.342-1.115,0.419c-0.318-0.335-0.775-0.545-1.279-0.545c-0.969,0-1.754,0.773-1.754,1.727c0,0.135,0.015,0.267,0.045,0.394C8.905,8.628,7.612,7.94,6.747,6.896C6.596,7.151,6.509,7.448,6.509,7.764c0,0.599,0.31,1.128,0.78,1.438C7.002,9.192,6.732,9.115,6.495,8.985c0,0.007,0,0.014,0,0.021c0,0.837,0.605,1.535,1.408,1.694c-0.147,0.04-0.302,0.06-0.462,0.06c-0.113,0-0.223-0.011-0.33-0.031c0.223,0.687,0.871,1.186,1.638,1.199c-0.6,0.464-1.356,0.739-2.179,0.739c-0.142,0-0.281-0.007-0.418-0.023c0.777,0.489,1.699,0.775,2.689,0.775c3.228,0,4.991-2.63,4.991-4.913c0-0.075-0.002-0.149-0.004-0.223c0.342-0.244,0.639-0.547,0.875-0.894c-0.316,0.137-0.652,0.23-1.008,0.272C14.057,7.448,14.336,7.11,14.467,6.707 M10,0.594c-5.195,0-9.406,4.211-9.406,9.406c0,5.195,4.211,9.406,9.406,9.406c5.196,0,9.407-4.211,9.407-9.406C19.406,4.805,15.195,0.594,10,0.594 M10,18.552c-4.723,0-8.551-3.829-8.551-8.552S5.277,1.449,10,1.449c4.723,0,8.551,3.829,8.551,8.551S14.723,18.552,10,18.552"></path>
                    </svg>
                </a>
                <a href="javascript:void(0)" v-if="isLinkedin" @click="onSocialLogin('linkedin')" class="mr-6 linkedin" title="Linkedin">
                    <svg class="h-10 w-10 text-blue-500" viewBox="0 0 67 67">
                        <path fill="currentColor" d="M50.837,48.137V36.425c0-6.275-3.35-9.195-7.816-9.195  c-3.604,0-5.219,1.983-6.119,3.374V27.71h-6.79c0.09,1.917,0,20.427,0,20.427h6.79V36.729c0-0.609,0.044-1.219,0.224-1.655  c0.49-1.22,1.607-2.483,3.482-2.483c2.458,0,3.44,1.873,3.44,4.618v10.929H50.837z M22.959,24.922c2.367,0,3.842-1.57,3.842-3.531  c-0.044-2.003-1.475-3.528-3.797-3.528s-3.841,1.524-3.841,3.528c0,1.961,1.474,3.531,3.753,3.531H22.959z M34,64  C17.432,64,4,50.568,4,34C4,17.431,17.432,4,34,4s30,13.431,30,30C64,50.568,50.568,64,34,64z M26.354,48.137V27.71h-6.789v20.427  H26.354z"></path>
                    </svg>
                </a>
                <a href="javascript:void(0)" v-if="isGoogle" @click="onSocialLogin('google')" class="google" title="Google">
                    <svg class="h-10 w-10 text-blue-500" viewBox="0 0 20 20">
                        <path fill="currentColor" d="M10,0.562c-5.212,0-9.438,4.226-9.438,9.438c0,5.213,4.226,9.438,9.438,9.438c5.212,0,9.438-4.225,9.438-9.438C19.438,4.788,15.212,0.562,10,0.562 M10,18.58c-4.738,0-8.58-3.841-8.58-8.58c0-4.738,3.842-8.58,8.58-8.58c4.737,0,8.579,3.841,8.579,8.58C18.579,14.739,14.737,18.58,10,18.58 M10.033,10.346C9.813,10.183,9.608,9.94,9.6,9.865c0-0.128,0-0.188,0.303-0.435c0.393-0.322,0.609-0.745,0.609-1.192c0-0.387-0.108-0.731-0.293-0.982h0.164l0.908-0.688H8.832c-0.986,0-1.851,0.774-1.851,1.657c0,0.912,0.667,1.604,1.565,1.642C8.533,9.933,8.525,9.996,8.525,10.06c0,0.131,0.03,0.257,0.09,0.378c-1.113,0.007-2.05,0.752-2.05,1.632c0,0.789,0.902,1.362,2.145,1.362c1.343,0,2.067-0.84,2.067-1.631C10.778,11.143,10.576,10.748,10.033,10.346 M8.026,8.198C7.985,7.869,8.054,7.565,8.212,7.384c0.096-0.11,0.22-0.169,0.358-0.169V7.036l0.016,0.179c0.412,0.014,0.807,0.501,0.88,1.086c0.042,0.335-0.03,0.647-0.191,0.833c-0.096,0.11-0.217,0.169-0.367,0.168h0C8.503,9.29,8.1,8.784,8.026,8.198 M8.707,12.749c-0.612,0-1.093-0.394-1.093-0.897c0-0.461,0.562-0.865,1.202-0.865v-0.18h0l0.017,0.18c0.138,0.002,0.272,0.022,0.399,0.062l0.126,0.092c0.326,0.231,0.498,0.363,0.549,0.575c0.013,0.056,0.019,0.111,0.019,0.167C9.927,12.458,9.517,12.749,8.707,12.749M13.43,6.993h-0.858v1.288H11.28V9.14h1.291v1.283h0.858V9.14h1.293V8.281H13.43V6.993z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

</template>

<script>

    import { storeLocalCredential, getDefaultRedirectRoute } from './../auth.js';

    export default {

        data() {
            return {
                email: null,
                password: null,

                isFacebook: null,
                isTwitter: null,
                isLinkedin: null,
                isGoogle: null,
                social: null,
            }
        },


        created() {
            // util.ajax ('get', '/api/social/providers', {},  (response) => {
            //     let providers = JSON.parse(response)
            //     this.isFacebook = providers.facebook == 'Enabled' ? true : false
            //     this.isTwitter = providers.twitter == 'Enabled' ? true : false
            //     this.isLinkedin = providers.linkedin == 'Enabled' ? true : false
            //     this.isGoogle = providers.google == 'Enabled' ? true : false
            //     this.social = this.isFacebook || this.isTwitter || this.isLinkedin || this.isGoogle
            // })
            window.axios.get('/api/check').then ((response) => {
                console.log('User');
                console.log(response.data);
                if (Object.keys(response.data).length != 0 && response.data.constructor === Object) {
                    this.onAuthSuccess(response);
                }
            });

        },


        methods: {

            attemptLogin() {
                window.axios.get('/api/airlock/csrf-cookie').then ((response) => {
                    window.axios.post('/api/login', {"email": this.email, "password": this.password})
                    .then(this.onAuthSuccess)
                    .catch(this.onAuthFail)
                })
            },

            onAuthSuccess (response) {

                if (['admin', 'author'].indexOf(response.data.role) === -1) {
                    util.notifyError ('Unauthorised', "Only Admins can access this page.")
                    return this.$router.replace('/')
                }

                let authUser = response.data

                storeLocalCredential(authUser)

                this.$emit('login', authUser)

                let redirectPath = this.$route.query.redirect
                if (!!redirectPath)
                    this.$router.replace(redirectPath)
                else
                    this.$router.replace({name: getDefaultRedirectRoute()})
            },

            onAuthFail (error) {

                if (error.response.status == 401) {
                    util.notifyError ('Invalid Login', error.response.data.message)
                } else if (error.response.status == 422) {
                    util.notifyError ('Account Locked', error.response.data.message)
                }
            },

            async onSocialLogin (provider) {

                await window.axios.get('/api/social/login/' + provider)
                .then(response => {
                    window.location.assign(response.data.url)
                    return
                })
                .catch(error => {
                    util.notifyError ('Social Login Error', error)
                })
            }

        }
    };

</script>

<style scoped>
    .bg-pattern {
        background-color: #ffffff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 4 4'%3E%3Cpath fill='%232b6cb0' fill-opacity='0.4' d='M1 3h1v1H1V3zm2-2h1v1H3V1z'%3E%3C/path%3E%3C/svg%3E");

    }
</style>