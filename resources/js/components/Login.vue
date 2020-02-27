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
        </div>
    </div>

</template>

<script>

    import { storeLocalCredential, getDefaultRedirectRoute } from './../auth.js';

    export default {

        data() {
            return {
                email: null,
                password: null
            }
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

                if (response.data.role !== 'admin') {
                    util.notifyError ('Unauthorised', "Only Admins can access this page")
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