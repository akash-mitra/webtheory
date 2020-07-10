<template>
    <div class="w-full">
        <div
            v-if="socialprovider !== null && socialProviderRedirectUrl !== null"
            class="rounded w-full mb-6 shadow"
        >
            <div class="px-6 py-3 border-b bg-white rounded">
                <div class="w-full relative">
                    <div
                        class="absolute top-0 right-0 mr-8 text-xs border py-1 px-2 rounded-lg cursor-pointer"
                        @click="
                            changeStatus(
                                'google',
                                socialprovider.google === 'Disabled' ? 'Enabled' : 'Disabled'
                            )
                        "
                    >
                        <div class="flex items-center">
                            <div
                                :class="
                                    socialprovider.google === 'Disabled'
                                        ? 'bg-gray-400'
                                        : 'bg-green-400'
                                "
                                class="rounded-full h-3 w-3 mr-2"
                            ></div>
                            <span
                                :class="
                                    socialprovider.google === 'Disabled'
                                        ? 'text-gray-600'
                                        : 'text-green-600'
                                "
                                >{{ socialprovider.google }}</span
                            >
                        </div>
                    </div>
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
                </div>

                <div class="p-3" v-if="socialprovider.google == 'Enabled'">
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
                        <label for="google_redirect" class="block w-full sm:w-1/4 text-sm py-1"
                            >Redirect URL</label
                        >
                        <div class="text-gray-800 text-sm w-full sm:w-3/4 max-w-lg py-1">
                            {{ socialProviderRedirectUrl.google }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-3 border-b bg-white rounded">
                <div class="w-full relative">
                    <div
                        class="absolute top-0 right-0 mr-8 text-xs border py-1 px-2 rounded-lg cursor-pointer"
                        @click="
                            changeStatus(
                                'facebook',
                                socialprovider.facebook === 'Disabled' ? 'Enabled' : 'Disabled'
                            )
                        "
                    >
                        <div class="flex items-center">
                            <div
                                :class="
                                    socialprovider.facebook === 'Disabled'
                                        ? 'bg-gray-400'
                                        : 'bg-green-400'
                                "
                                class="rounded-full h-3 w-3 mr-2"
                            ></div>
                            <span
                                :class="
                                    socialprovider.facebook === 'Disabled'
                                        ? 'text-gray-600'
                                        : 'text-green-600'
                                "
                                >{{ socialprovider.facebook }}</span
                            >
                        </div>
                    </div>
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
                </div>

                <div class="p-3" v-if="socialprovider.facebook == 'Enabled'">
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

            <div class="px-6 py-3 border-b bg-white rounded">
                <div class="w-full relative">
                    <div
                        class="absolute top-0 right-0 mr-8 text-xs border py-1 px-2 rounded-lg cursor-pointer"
                        @click="
                            changeStatus(
                                'twitter',
                                socialprovider.twitter === 'Disabled' ? 'Enabled' : 'Disabled'
                            )
                        "
                    >
                        <div class="flex items-center">
                            <div
                                :class="
                                    socialprovider.twitter === 'Disabled'
                                        ? 'bg-gray-400'
                                        : 'bg-green-400'
                                "
                                class="rounded-full h-3 w-3 mr-2"
                            ></div>
                            <span
                                :class="
                                    socialprovider.twitter === 'Disabled'
                                        ? 'text-gray-600'
                                        : 'text-green-600'
                                "
                                >{{ socialprovider.twitter }}</span
                            >
                        </div>
                    </div>
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
                </div>

                <div class="p-3" v-if="socialprovider.twitter == 'Enabled'">
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
                    <div class="w-full sm:flex mt-2">
                        <label for="twitter_redirect" class="block w-full sm:w-1/4 text-sm py-1"
                            >Redirect URL</label
                        >
                        <div class="text-gray-800 text-sm w-full sm:w-3/4 max-w-lg py-1">
                            {{ socialProviderRedirectUrl.twitter }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <t-button :loadingWheel="isSaving" textSize="normal" @click.native="saveSocialLogin">
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
            let p = this

            p.isSaving = true

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

            util.ajax('post', '/api/settings/loginprovider', { data }, function () {
                p.isSaving = false

                util.notifySuccess(
                    'Saved',
                    'Login provider constants have been successfully saved.'
                )
            })
        },

        changeStatus(provider, status) {
            let p = this

            p.isSaving = true

            if (provider == 'facebook') this.socialprovider.facebook = status
            else if (provider == 'twitter') this.socialprovider.twitter = status
            else if (provider == 'linkedin') this.socialprovider.linkedin = status
            else if (provider == 'google') this.socialprovider.google = status

            util.ajax(
                'post',
                '/api/parameters/socialprovider',
                { value: JSON.stringify(this.socialprovider) },
                function () {
                    p.isSaving = false

                    util.notifySuccess('Saved', 'Login provider have been ' + status)
                }
            )
        },
    },
}
</script>
