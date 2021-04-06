<template>
    <div class="w-full">
        <div v-for="i in Array(3).keys()" v-show="isLoading">
            <div class="border-b bg-white rounded mb-3 pb-3">
                <div class="w-full border-b px-6 py-2">
                    <h3 class="text-blue-800 font-semibold flex items-center py-1">
                        <div class="rounded-full w-8 h-8 bg-blue-200"></div>
                        <div class="w-32 h-6 bg-gray-300 ml-4"></div>
                    </h3>
                </div>

                <div class="px-6 py-2 flex">
                    <div class="w-1/4">
                        <label class="text-sm py-1 bg-gray-200 text-gray-200">Lorem, ipsum.</label>
                    </div>
                    <div class="w-3/4">
                        <span class="px-2 py-1 bg-blue-200 text-blue-200">
                            Lorem
                        </span>
                    </div>
                </div>
                <div class="px-6 py-2 flex">
                    <div class="w-1/4">
                        <label class="text-sm py-1 bg-gray-200 text-gray-200">Lorem, ipsum.</label>
                    </div>
                    <div class="w-3/4">
                        <span class="px-2 py-1 bg-gray-200 text-gray-200">
                            Lorem ipsum dolor sit amet consectetur adipisicing shdjgc.
                        </span>
                    </div>
                </div>
                <div class="px-6 py-2 flex">
                    <div class="w-1/4">
                        <label class="text-sm py-1 bg-gray-200 text-gray-200">Lorem, ipsum.</label>
                    </div>
                    <div class="w-3/4">
                        <span class="px-2 py-1 bg-gray-200 text-gray-200">
                            Lorem ipsum dolor sit amet consectetur adipisicing shdjgc.
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="socialprovider !== null && socialProviderRedirectUrl !== null"
            class="rounded w-full shadow"
        >
            <div class="border-b bg-white rounded mb-3 pb-3">
                <div class="w-full border-b px-6 py-2 flex justify-between items-center">
                    <h3 class="text-blue-800 font-semibold flex items-center py-1">
                        <svg
                            viewBox="0 0 512 512"
                            class="w-8 h-8 mr-3 ml-2 -mb-4 fill-current text-blue-400"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M332 150v15a166 166 0 01-332 0A166 166 0 01294 59l-43 43a106 106 0 00-191 63 106 106 0 00202 45h-81v-60zm0 0M512 135v60h-45v45h-60v-45h-45v-60h45V90h60v45zm0 0"
                                fill="#ff3939"
                            />
                            <g fill="#c90232">
                                <path
                                    d="M166 60V0c52 0 102 26 128 59l-43 43c-18-24-50-42-85-42zm0 0M332 150v15a166 166 0 01-166 165v-60c42 0 79-25 96-60h-81v-60zm0 0M512 135v60h-45v45h-30V90h30v45zm0 0"
                                />
                            </g>
                        </svg>
                        Google
                    </h3>
                    <a
                        href="https://console.developers.google.com/"
                        target='_blank'
                        class='text-blue-400 cursor-pointer text-sm'
                        >Google Developer Console</a
                    >
                </div>

                <div class="px-6 py-2">
                    <div class="w-full sm:flex mt-2">
                        <label for="google-enabled" class="block w-full sm:w-1/4 text-sm py-1"
                            >Google Login</label
                        >
                        <t-toggle
                            v-model="socialprovider.google"
                            true-value="On"
                            false-value="Off"
                            box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                            true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                            false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                            :show-value="true"
                        >
                        </t-toggle>
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="googleClientId" class="block w-full sm:w-1/4 text-sm py-1"
                            >Client Id</label
                        >
                        <input
                            type="text"
                            id="googleClientId"
                            v-model="googleClientId"
                            ref="googleClientId"
                            class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                        />
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="googleClientSecret" class="block w-full sm:w-1/4 text-sm py-1"
                            >Client Secret</label
                        >
                        <input
                            type="text"
                            id="googleClientSecret"
                            v-model="googleClientSecret"
                            ref="googleClientSecret"
                            class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                        />
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <div for="google_redirect" class="block w-full sm:w-1/4 text-sm py-1">
                            Redirect URL
                        </div>
                        <div class="text-gray-800 text-sm w-full sm:w-3/4 max-w-lg py-1">
                            {{ socialProviderRedirectUrl.google }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-b bg-white rounded mb-3 pb-3">
                <div class="w-full border-b px-6 py-2 flex justify-between items-center">
                    <h3 class="text-blue-800 font-semibold flex items-center">
                        <svg
                            class="w-8 h-8 mr-4 fill-current text-blue-400"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M448 0H64C29 0 0 29 0 64v384c0 35 29 64 64 64h384c35 0 64-29 64-64V64c0-35-29-64-64-64z"
                                fill="#1976d2"
                            />
                            <path
                                d="M432 256h-80v-64c0-18 14-16 32-16h32V96h-64c-53 0-96 43-96 96v64h-64v80h64v176h96V336h48l32-80z"
                                fill="#fafafa"
                            />
                        </svg>
                        Facebook
                    </h3>
                    <a
                        href="https://developers.facebook.com/apps/"
                        target='_blank'
                        class='text-blue-400 cursor-pointer text-sm'
                        >Facebook Developer Console</a
                    >
                </div>

                <div class="px-6 py-2">
                    <div class="w-full sm:flex mt-2">
                        <label for="facebook-enabled" class="block w-full sm:w-1/4 text-sm py-1"
                            >Facebook Login</label
                        >
                        <t-toggle
                            v-model="socialprovider.facebook"
                            true-value="On"
                            false-value="Off"
                            box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                            true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                            false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                            :show-value="true"
                        >
                        </t-toggle>
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="facebookClientId" class="block w-full sm:w-1/4 text-sm py-1"
                            >App Id</label
                        >
                        <input
                            type="text"
                            id="facebookClientId"
                            v-model="facebookClientId"
                            ref="facebookClientId"
                            class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                        />
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="facebookClientSecret" class="block w-full sm:w-1/4 text-sm py-1"
                            >App Secret</label
                        >
                        <input
                            type="text"
                            id="facebookClientSecret"
                            v-model="facebookClientSecret"
                            ref="facebookClientSecret"
                            class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                        />
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="facebook_redirect" class="block w-full sm:w-1/4 text-sm py-1"
                            >Redirect URL</label
                        >
                        <div class="text-gray-800 text-sm w-full sm:w-3/4 max-w-lg py-1">
                            {{ socialProviderRedirectUrl.facebook }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-b bg-white rounded mb-3 pb-3">
                <div class="w-full border-b px-6 py-2 flex justify-between items-center">
                    <h3 class="text-blue-800 font-semibold flex items-center">
                        <svg
                            viewBox="0 0 512 512"
                            class="w-8 h-8 mr-4 fill-current text-blue-400"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M512 97c-19 9-39 14-60 17 21-13 38-34 46-58-21 12-43 20-67 25a105 105 0 00-179 96c-87-4-164-46-216-110a106 106 0 0032 140c-17 0-34-5-48-13v2c0 51 37 93 85 103a105 105 0 01-48 1c14 42 52 73 98 74A211 211 0 010 417c46 30 102 47 161 47a297 297 0 00298-312c21-15 39-34 53-55z"
                                fill="#03a9f4"
                            />
                        </svg>
                        Twitter
                    </h3>
                    <a
                        href="https://developer.twitter.com/"
                        target='_blank'
                        class='text-blue-400 cursor-pointer text-sm'
                        >Twitter Developer Console</a
                    >
                </div>

                <div class="px-6 py-2">
                    <div class="w-full sm:flex mt-2">
                        <label for="twitter-enabled" class="block w-full sm:w-1/4 text-sm py-1"
                            >Twiiter Login</label
                        >
                        <t-toggle
                            v-model="socialprovider.twitter"
                            true-value="On"
                            false-value="Off"
                            box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                            true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                            false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                            :show-value="true"
                        >
                        </t-toggle>
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="twitterClientId" class="block w-full sm:w-1/4 text-sm py-1"
                            >API Key</label
                        >
                        <input
                            type="text"
                            id="twitterClientId"
                            v-model="twitterClientId"
                            ref="twitterClientId"
                            class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                        />
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="twitterClientSecret" class="block w-full sm:w-1/4 text-sm py-1"
                            >API Secret Key</label
                        >
                        <input
                            type="text"
                            id="twitterClientSecret"
                            v-model="twitterClientSecret"
                            ref="twitterClientSecret"
                            class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                        />
                    </div>
                    <div class='w-full sm:flex mt-2'>
                        <label for='twitter_redirect' class='block w-full sm:w-1/4 text-sm py-1'
                        >Redirect URL</label
                        >
                        <div class='text-gray-800 text-sm w-full sm:w-3/4 max-w-lg py-1'>
                            {{ socialProviderRedirectUrl.twitter }}
                        </div>
                    </div>
                </div>
            </div>


            <div class='border-b bg-white rounded mb-3 pb-3'>
                <div class='w-full border-b px-6 py-2 flex justify-between items-center'>
                    <h3 class='text-blue-800 font-semibold flex items-center'>
                        <img class='w-8 h-8 mr-4' src='/images/tensor.svg' />
                        WebTheory Login
                    </h3>
                    <span
                        class='text-gray-600 cursor-pointer text-sm'
                    >Login system provided natively by WebTheory</span
                    >
                </div>

                <div class='px-6 py-2'>
                    <div class='w-full sm:flex mt-2'>
                        <label class='block w-full sm:w-1/4 text-sm py-1' for='webtheory-enabled'
                        >Enable Native Login</label
                        >
                        <t-toggle
                            id='webtheory-enabled'
                            v-model='socialprovider.webtheory'
                            :show-value='true'
                            box-class='w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer'
                            false-class='h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm'
                            false-value='Off'
                            true-class='h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm'
                            true-value='On'
                        >
                        </t-toggle>
                    </div>

                </div>
            </div>
        </div>

        <t-button
            :loadingWheel="isSaving"
            textSize="normal"
            @click.native="saveSocialLogin"
            class="mt-6"
        >
            Save Login Settings
        </t-button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            socialprovider: null,

            googleClientId: null,
            googleClientSecret: null,

            facebookClientId: null,
            facebookClientSecret: null,

            twitterClientId: null,
            twitterClientSecret: null,

            socialProviderRedirectUrl: null,

            isSaving: false,
            isLoading: true,
        }
    },

    created() {
        this.isLoading = true

        util.ajax('get', '/api/parameters/socialprovider', {}, (response) => {
            this.socialprovider = JSON.parse(response)
        })

        util.ajax('get', '/api/parameters/socialprovider_redirect_url', {}, (response) => {
            this.socialProviderRedirectUrl = JSON.parse(response)
        })

        util.ajax('get', '/api/settings/social', {}, (response) => {
            this.facebookClientId = response['FACEBOOK_CLIENT_ID']
            this.facebookClientSecret = response['FACEBOOK_CLIENT_SECRET']
            this.twitterClientId = response['TWITTER_CLIENT_ID']
            this.twitterClientSecret = response['TWITTER_CLIENT_SECRET']
            this.linkedinClientId = response['LINKEDIN_CLIENT_ID']
            this.linkedinClientSecret = response['LINKEDIN_CLIENT_SECRET']
            this.googleClientId = response['GOOGLE_CLIENT_ID']
            this.googleClientSecret = response['GOOGLE_CLIENT_SECRET']

            this.isLoading = false
        })
    },

    methods: {
        saveSocialLogin() {
            if (!this.atLeastOneLoginMethodIsEnabled()) {
                util.notifyError('Enable Login', 'At least one login method must be enabled.')
                return
            }

            let data = [
                { key: 'FACEBOOK_CLIENT_ID', value: this.facebookClientId },
                { key: 'FACEBOOK_CLIENT_SECRET', value: this.facebookClientSecret },
                { key: 'TWITTER_CLIENT_ID', value: this.twitterClientId },
                { key: 'TWITTER_CLIENT_SECRET', value: this.twitterClientSecret },
                { key: 'LINKEDIN_CLIENT_ID', value: this.linkedinClientId },
                { key: 'LINKEDIN_CLIENT_SECRET', value: this.linkedinClientSecret },
                { key: 'GOOGLE_CLIENT_ID', value: this.googleClientId },
                { key: 'GOOGLE_CLIENT_SECRET', value: this.googleClientSecret },
            ]

            let p = this
            p.isSaving = true

            util.ajax('post', '/api/settings/loginprovider', { data }, function() {
                util.ajax(
                    'post',
                    '/api/parameters/socialprovider',
                    { value: JSON.stringify(p.socialprovider) },
                    () => {
                        p.isSaving = false

                        util.notifySuccess('Saved', 'Login provider have been ' + status)
                    },
                )
            })
        },

        atLeastOneLoginMethodIsEnabled() {
            return this.socialprovider.google === 'On'
                || this.socialprovider.facebook === 'On'
                || this.socialprovider.twitter === 'On'
                || this.socialprovider.webtheory === 'On'
        },
    },
}
</script>
