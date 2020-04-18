<template>

    <div class="max-w-5xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">Settings</h2>
            <!-- <a href="/app/settings/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">Create</a> -->

            <t-button :loadingWheel="isSaving" @click.native="initiateSave">
                Save Settings
            </t-button>
        </div>


        <div class="px-6 w-full flex justify-between items-center my-8 border-b">
            <div class="flex justify-start">
                <div @click="tab='login'" class="-ml-4 px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='login'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Login
                </div>
                <div @click="tab='ads'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='ads'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Ad Sense
                </div>
                <div @click="tab='payment'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='payment'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Payment
                </div>
            </div>
        </div>


        <div class="pb-10" v-if="tab=='login'">

            <p class="text-sm text-gray-700 pb-3 uppercase">Social Login</p>

            <div v-if="providers!==null && providerRedirectUrls!==null" class="rounded w-full">


                <div class="px-6 py-3 mb-4 bg-white shadow rounded">
                    <div class="w-full relative">
                        <div class="absolute top-0 right-0 mr-8 text-xs border py-1 px-2 rounded-lg cursor-pointer"
                            @click="changeStatus('facebook', providers.facebook==='Disabled'?'Enabled':'Disabled')">

                            <div class="flex items-center">
                                <div :class="providers.facebook==='Disabled'? 'bg-gray-400':'bg-green-400'" class="rounded-full h-3 w-3 mr-2"></div>
                                <span :class="providers.facebook==='Disabled'? 'text-gray-600':'text-green-600'">{{ providers.facebook }}</span>
                            </div>
                        </div>
                        <h3 class="text-blue-800 font-semibold flex items-center">
                        <svg class="w-8 h-8 mr-4 fill-current text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 0H64C29 0 0 29 0 64v384c0 35 29 64 64 64h384c35 0 64-29 64-64V64c0-35-29-64-64-64z" fill="#1976d2"/><path d="M432 256h-80v-64c0-18 14-16 32-16h32V96h-64c-53 0-96 43-96 96v64h-64v80h64v176h96V336h48l32-80z" fill="#fafafa"/></svg>
                        Facebook
                        </h3>
                    </div>

                    <div v-if="providers.facebook=='Enabled'">
                        <div class="w-full sm:flex mt-2">
                            <label for="facebook_redirect" class="block w-full sm:w-1/4 text-sm py-1 ">Redirect URL</label>
                            <div class="text-blue-700 w-full sm:w-3/4 max-w-lg py-1 ">{{ providerRedirectUrls.facebook }}</div>
                        </div>
                        <div class="w-full sm:flex mt-2">
                            <label for="facebookClientId" class="block w-full sm:w-1/4 text-sm py-1 ">Client Id</label>
                            <input type="text" id="facebookClientId" v-model="facebookClientId" ref="facebookClientId" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div class="w-full sm:flex mt-2">
                            <label for="facebookClientSecret" class="block w-full sm:w-1/4 text-sm py-1 ">Client Secret</label>
                            <input type="text" id="facebookClientSecret" v-model="facebookClientSecret" ref="facebookClientSecret" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                    </div>
                </div>


                <div class="px-6 py-3 mb-4 bg-white shadow rounded">
                    <div class="w-full relative">
                        <div class="absolute top-0 right-0 mr-8 text-xs border py-1 px-2 rounded-lg cursor-pointer"
                            @click="changeStatus('twitter', providers.twitter==='Disabled'?'Enabled':'Disabled')">

                            <div class="flex items-center">
                                <div :class="providers.twitter==='Disabled'? 'bg-gray-400':'bg-green-400'" class="rounded-full h-3 w-3 mr-2"></div>
                                <span :class="providers.twitter==='Disabled'? 'text-gray-600':'text-green-600'">{{ providers.twitter }}</span>
                            </div>
                        </div>
                        <h3 class="text-blue-800 font-semibold flex items-center">
                        <svg viewBox="0 0 512 512" class="w-8 h-8 mr-4 fill-current text-blue-400" xmlns="http://www.w3.org/2000/svg"><path d="M512 97c-19 9-39 14-60 17 21-13 38-34 46-58-21 12-43 20-67 25a105 105 0 00-179 96c-87-4-164-46-216-110a106 106 0 0032 140c-17 0-34-5-48-13v2c0 51 37 93 85 103a105 105 0 01-48 1c14 42 52 73 98 74A211 211 0 010 417c46 30 102 47 161 47a297 297 0 00298-312c21-15 39-34 53-55z" fill="#03a9f4"/></svg>
                        Twitter
                        </h3>
                    </div>

                    <div v-if="providers.twitter=='Enabled'">
                        <div class="w-full sm:flex mt-2">
                            <label for="twitter_redirect" class="block w-full sm:w-1/4 text-sm py-1 ">Redirect URL</label>
                            <div class="text-blue-700 w-full sm:w-3/4 max-w-lg py-1 ">{{ providerRedirectUrls.twitter }}</div>
                        </div>
                        <div class="w-full sm:flex mt-2">
                            <label for="twitterClientId" class="block w-full sm:w-1/4 text-sm py-1 ">Client Id</label>
                            <input type="text" id="twitterClientId" v-model="twitterClientId" ref="twitterClientId" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div class="w-full sm:flex mt-2">
                            <label for="twitterClientSecret" class="block w-full sm:w-1/4 text-sm py-1 ">Client Secret</label>
                            <input type="text" id="twitterClientSecret" v-model="twitterClientSecret" ref="twitterClientSecret" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                    </div>
                </div>


                <div class="px-6 py-3 mb-4 bg-white shadow rounded">
                    <div class="w-full relative">
                        <div class="absolute top-0 right-0 mr-8 text-xs border py-1 px-2 rounded-lg cursor-pointer"
                            @click="changeStatus('linkedin', providers.linkedin==='Disabled'?'Enabled':'Disabled')">

                            <div class="flex items-center">
                                <div :class="providers.linkedin==='Disabled'? 'bg-gray-400':'bg-green-400'" class="rounded-full h-3 w-3 mr-2"></div>
                                <span :class="providers.linkedin==='Disabled'? 'text-gray-600':'text-green-600'">{{ providers.linkedin }}</span>
                            </div>
                        </div>
                        <h3 class="text-blue-800 font-semibold flex items-center">
                        <svg viewBox="0 0 512 512" class="w-8 h-8 mr-4 fill-current text-blue-400" xmlns="http://www.w3.org/2000/svg"><path d="M437 0H75C34 0 0 35 0 76v361c0 41 34 75 75 75h362c41 0 75-34 75-75V76c0-41-34-76-75-76zm0 0" fill="#25d9f8"/><path d="M512 76v361c0 41-34 75-75 75H256V0h181c41 0 75 35 75 76zm0 0" fill="#00c0f1"/><g fill="#ececf1"><path d="M121 196h60v211h-60zm0 0M121 106h60v60h-60zm0 0M391 276v131h-60V286c0-16-13-30-30-30s-30 14-30 30v121h-60V196h60v11c16-5 26-11 45-11 41 0 75 37 75 80zm0 0"/></g><path d="M391 276v131h-60V286c0-16-13-30-30-30s-30 14-30 30v121h-15V196h15v11c16-5 26-11 45-11 41 0 75 37 75 80zm0 0" fill="#e2e2e7"/></svg>
                        Linkedin
                        </h3>
                    </div>

                    <div v-if="providers.linkedin=='Enabled'">
                        <div class="w-full sm:flex mt-2">
                            <label for="linkedin_redirect" class="block w-full sm:w-1/4 text-sm py-1 ">Redirect URL</label>
                            <div class="text-blue-700 w-full sm:w-3/4 max-w-lg py-1 ">{{ providerRedirectUrls.linkedin }}</div>
                        </div>
                        <div class="w-full sm:flex mt-2">
                            <label for="linkedinClientId" class="block w-full sm:w-1/4 text-sm py-1 ">Client Id</label>
                            <input type="text" id="linkedinClientId" v-model="linkedinClientId" ref="linkedinClientId" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div class="w-full sm:flex mt-2">
                            <label for="linkedinClientSecret" class="block w-full sm:w-1/4 text-sm py-1 ">Client Secret</label>
                            <input type="text" id="linkedinClientSecret" v-model="linkedinClientSecret" ref="linkedinClientSecret" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                    </div>
                </div>


                <div class="px-6 py-3 mb-4 bg-white shadow rounded">
                    <div class="w-full relative">
                        <div class="absolute top-0 right-0 mr-8 text-xs border py-1 px-2 rounded-lg cursor-pointer"
                            @click="changeStatus('google', providers.google==='Disabled'?'Enabled':'Disabled')">

                            <div class="flex items-center">
                                <div :class="providers.google==='Disabled'? 'bg-gray-400':'bg-green-400'" class="rounded-full h-3 w-3 mr-2"></div>
                                <span :class="providers.google==='Disabled'? 'text-gray-600':'text-green-600'">{{ providers.google }}</span>
                            </div>
                        </div>
                        <h3 class="text-blue-800 font-semibold flex items-center">
                        <svg viewBox="0 0 512 512" class="w-8 h-8 mr-4 fill-current text-blue-400" xmlns="http://www.w3.org/2000/svg"><path d="M332 150v15a166 166 0 01-332 0A166 166 0 01294 59l-43 43a106 106 0 00-191 63 106 106 0 00202 45h-81v-60zm0 0M512 135v60h-45v45h-60v-45h-45v-60h45V90h60v45zm0 0" fill="#ff3939"/><g fill="#c90232"><path d="M166 60V0c52 0 102 26 128 59l-43 43c-18-24-50-42-85-42zm0 0M332 150v15a166 166 0 01-166 165v-60c42 0 79-25 96-60h-81v-60zm0 0M512 135v60h-45v45h-30V90h30v45zm0 0"/></g></svg>
                        Google
                        </h3>
                    </div>

                    <div v-if="providers.google=='Enabled'">
                        <div class="w-full sm:flex mt-2">
                            <label for="google_redirect" class="block w-full sm:w-1/4 text-sm py-1 ">Redirect URL</label>
                            <div class="text-blue-700 w-full sm:w-3/4 max-w-lg py-1 ">{{ providerRedirectUrls.google }}</div>
                        </div>
                        <div class="w-full sm:flex mt-2">
                            <label for="googleClientId" class="block w-full sm:w-1/4 text-sm py-1 ">Client Id</label>
                            <input type="text" id="googleClientId" v-model="googleClientId" ref="googleClientId" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div class="w-full sm:flex mt-2">
                            <label for="googleClientSecret" class="block w-full sm:w-1/4 text-sm py-1 ">Client Secret</label>
                            <input type="text" id="googleClientSecret" v-model="googleClientSecret" ref="googleClientSecret" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                    </div>
                </div>


            </div>



        </div>

    </div>
</template>

<script>
    export default {

        data() {
            return {
                templates: [],
                isSaving: false,

                selected: null,
                tab: 'login',
                searchPhrase: '',

                sitetitle: '',
                sitename: '',
                sitedesc: '',

                isSaving: false,

                providers: null,
                providerRedirectUrls: null,
                facebookClientId: null,
                facebookClientSecret: null,
                twitterClientId: null,
                twitterClientSecret: null,
                linkedinClientId: null,
                linkedinClientSecret: null,
                googleClientId: null,
                googleClientSecret: null,

            }
        },

        created() {

            util.ajax ('get', '/api/parameters/providers', {},  (response) => {
                this.providers = JSON.parse(response)
            })
            util.ajax ('get', '/api/parameters/provider_redirect_urls', {},  (response) => {
                this.providerRedirectUrls = JSON.parse(response)
            })
            util.ajax ('get', '/api/parameters/FACEBOOK_CLIENT_ID', {},  (response) => {
                this.facebookClientId = response
            })
            util.ajax ('get', '/api/parameters/FACEBOOK_CLIENT_SECRET', {},  (response) => {
                this.facebookClientSecret = response
            })
            util.ajax ('get', '/api/parameters/TWITTER_CLIENT_ID', {},  (response) => {
                this.twitterClientId = response
            })
            util.ajax ('get', '/api/parameters/TWITTER_CLIENT_SECRET', {},  (response) => {
                this.twitterClientSecret = response
            })
            util.ajax ('get', '/api/parameters/LINKEDIN_CLIENT_ID', {},  (response) => {
                this.linkedinClientId = response
            })
            util.ajax ('get', '/api/parameters/LINKEDIN_CLIENT_SECRET', {},  (response) => {
                this.linkedinClientSecret = response
            })
            util.ajax ('get', '/api/parameters/GOOGLE_CLIENT_ID', {},  (response) => {
                this.googleClientId = response
            })
            util.ajax ('get', '/api/parameters/GOOGLE_CLIENT_SECRET', {},  (response) => {
                this.googleClientSecret = response
            })

        },


        methods: {

            initiateSave () {
                let data = [
                        { 'key': 'FACEBOOK_CLIENT_ID', 'value': this.facebookClientId },
                        { 'key': 'FACEBOOK_CLIENT_SECRET', 'value': this.facebookClientSecret },
                        { 'key': 'TWITTER_CLIENT_ID', 'value': this.twitterClientId },
                        { 'key': 'TWITTER_CLIENT_SECRET', 'value': this.twitterClientSecret },
                        { 'key': 'LINKEDIN_CLIENT_ID', 'value': this.linkedinClientId },
                        { 'key': 'LINKEDIN_CLIENT_SECRET', 'value': this.linkedinClientSecret },
                        { 'key': 'GOOGLE_CLIENT_ID', 'value': this.googleClientId },
                        { 'key': 'GOOGLE_CLIENT_SECRET', 'value': this.googleClientSecret },
                    ]

                util.ajax ('post', '/api/settings/loginprovider', { data }, function () {
                    util.notifySuccess ('Saved', 'Login provider constants have been successfully saved.')
                })
            },

            changeStatus (provider, status)
            {
                if (provider == 'facebook')
                    this.providers.facebook = status
                else if (provider == 'twitter')
                    this.providers.twitter = status
                else if (provider == 'linkedin')
                    this.providers.linkedin = status
                else if (provider == 'google')
                    this.providers.google = status

                util.ajax ('post', '/api/parameters/providers', { "value": JSON.stringify(this.providers) }, function () {
                    util.notifySuccess ('Saved', 'Login provider have been ' + status)
                })
            },

        }

    };

</script>
