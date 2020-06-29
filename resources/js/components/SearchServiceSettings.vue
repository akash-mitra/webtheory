<template>

    <div class="w-full">

        <div class="rounded bg-white shadow">

            <p class="text-sm px-6 py-4 border-b text-gray-700 uppercase">Full Text Search</p>



                <div class="text-sm text-gray-700 p-6">
                    Enable full-text search on every page of your website using Algolia.<br>
                    <a class="text-blue-500 underline" href="https://www.algolia.com/pricing/" target="_blank">Create Algolia account</a> and provide the API details below.

                </div>

                <div class="w-full my-4 bg-gray-100 py-4 px-6 shadow-inner border-b border-t">
                    <div class="w-full sm:flex mt-2">
                        <label for="appId" class="block w-full sm:w-1/5 mr-4 text-sm py-1">Algolia APP ID</label>
                        <input type="text" id="appId" v-model="appId" ref="appId" class="w-full sm:w-4/5 max-w-lg px-2 py-1 rounded appearance-none bg-gray-2001 focus:bg-white border focus:outline-none">
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="appSecret" class="block w-full sm:w-1/5 mr-4 text-sm py-1">Algolia Secret</label>
                        <input type="text" id="appSecret" v-model="appSecret" ref="appSecret" class="w-full sm:w-4/5 max-w-lg px-2 py-1 rounded appearance-none bg-gray-2001 focus:bg-white border focus:outline-none">
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="appId" class="block w-full sm:w-1/5 mr-4 text-sm py-1">Using Community Plan?</label>
                        <t-toggle
                            v-model="communityPlan"
                            true-value="1"
                            false-value="0"
                            box-class="w-12 border shadow-inner bg-white rounded-l-full rounded-r-full cursor-pointer"
                            true-class="h-6 w-6 bg-green-400 rounded-full shadow-sm"
                            false-class="h-6 w-6 bg-gray-400 rounded-full shadow-sm"
                            >
                            <span class="text-sm text-gray-700 ml-3" v-if="communityPlan === '1'">Yes</span>
                            <span class="text-sm text-gray-700 ml-3" v-else>No</span>
                        </t-toggle>
                    </div>
                </div>

                <div class="p-6">
                    <t-button v-if="enabled==='0'" :loadingWheel="isUpdating" textSize="normal" @click.native="updateSearchSettings">
                        Enable Search
                    </t-button>
                    <t-button v-else :loadingWheel="isUpdating" textSize="normal" @click.native="updateSearchSettings">
                        Disable Search
                    </t-button>
                </div>


        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            enabled: "0",
            appId: null,
            appSecret: null,
            communityPlan: "1",

            isUpdating: false,
        }
    },

    created() {

        this.isUpdating = true

        // util.ajax ('get', '/api/parameters/socialprovider', {},  (response) => {
        //         this.socialprovider = JSON.parse(response)
        // })

        // util.ajax ('get', '/api/parameters/socialprovider_redirect_url', {},  (response) => {
        //     this.socialProviderRedirectUrl = JSON.parse(response)
        // })

        // util.ajax ('get', '/api/settings/social', {},  (response) => {
        //     this.facebookClientId = response['FACEBOOK_CLIENT_ID']
        //     this.facebookClientSecret = response['FACEBOOK_CLIENT_SECRET']
        //     this.twitterClientId = response['TWITTER_CLIENT_ID']
        //     this.twitterClientSecret = response['TWITTER_CLIENT_SECRET']
        //     this.linkedinClientId = response['LINKEDIN_CLIENT_ID']
        //     this.linkedinClientSecret = response['LINKEDIN_CLIENT_SECRET']
        //     this.googleClientId = response['GOOGLE_CLIENT_ID']
        //     this.googleClientSecret = response['GOOGLE_CLIENT_SECRET']

        //     this.isLoading = false
        // })
    },

    methods: {

        updateSearchSettings () {

            let p = this
            p.isUpdating = true

            // window.axios.post('/api/settings/update/', {"commit_id": commitId})
            // .then(response => {
            //     util.notifySuccess ('Success', response.data)
            //     p.isUpdating = false
            // })
            // .catch(error => {
            //     util.notifyError ('Error', error)
            //     p.isUpdating = false
            // })
        }
    }
}
</script>