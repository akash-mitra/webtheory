<template>

    <div></div>

</template>

<script>

    import { storeLocalCredential, getDefaultRedirectRoute } from './../auth.js';

    export default {

        data() {
            return {
                provider: null,
                code: null,
                oauth_token: null,
                oauth_verifier: null,
                user: {},
                
            }
        },
  
        async mounted() {
            
            if (this.$route.params.provider !== undefined) {
                this.provider = this.$route.params.provider
            }
            if (this.$route.query.code !== undefined) {
                this.code = this.$route.query.code
            }

            if (this.$route.query.oauth_token !== undefined) {
                this.oauth_token = this.$route.query.oauth_token
            }
            if (this.$route.query.oauth_verifier !== undefined) {
                this.oauth_verifier = this.$route.query.oauth_verifier
            }
            
            if (this.provider == 'twitter')
                await window.axios.get('/api/social/login/' + this.provider + '/callback?oauth_token=' + this.oauth_token + '&oauth_verifier=' + this.oauth_verifier)
                    .then(this.onSuccess)
                    .catch(error => {
                        util.notifyError ('Social Login Error', error)
                    })
            else
                await window.axios.get('/api/social/login/' + this.provider + '/callback?code=' + this.code)
                    .then(this.onSuccess)
                    .catch(error => {
                        util.notifyError ('Social Login Error', error)
                    })


        },

        methods: {
            
            onSuccess (response) {
                
                if (response.data.role !== 'admin') {
                    // util.notifyError ('Unauthorised', "Only Admins can access this page")
                    location.href = '/'
                } else {
                    console.log('bal')
                    let authUser = response.data

                    storeLocalCredential(authUser)

                    this.$emit('login', authUser)

                    let redirectPath = this.$route.query.redirect
                    if (!!redirectPath)
                        this.$router.replace(redirectPath)
                    else
                        this.$router.replace({name: getDefaultRedirectRoute()})
                }
            }

        }
};
</script>
