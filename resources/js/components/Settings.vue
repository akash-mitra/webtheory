<template>

    <div class="max-w-5xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">Settings</h2>
            <!-- <a href="/app/settings/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">Create</a> -->

            <t-button v-if="tab=='login'" :loadingWheel="isSaving" @click.native="saveSocialLogin">
                Save Settings
            </t-button>
            <t-button v-if="tab=='mail'" :loadingWheel="isSaving" @click.native="saveMail">
                Save Settings
            </t-button>
        </div>


        <div class="px-6 w-full flex justify-between items-center my-8 border-b">
            <div class="flex justify-start">
                <div @click="tab='login'" class="-ml-4 px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='login'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Login
                </div>
                <div @click="tab='mail'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='mail'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Mail
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

            <div v-if="socialprovider!==null && socialProviderRedirectUrl!==null" class="rounded w-full">


                <div class="px-6 py-3 mb-4 bg-white shadow rounded">
                    <div class="w-full relative">
                        <div class="absolute top-0 right-0 mr-8 text-xs border py-1 px-2 rounded-lg cursor-pointer"
                            @click="changeStatus('facebook', socialprovider.facebook==='Disabled'?'Enabled':'Disabled')">

                            <div class="flex items-center">
                                <div :class="socialprovider.facebook==='Disabled'? 'bg-gray-400':'bg-green-400'" class="rounded-full h-3 w-3 mr-2"></div>
                                <span :class="socialprovider.facebook==='Disabled'? 'text-gray-600':'text-green-600'">{{ socialprovider.facebook }}</span>
                            </div>
                        </div>
                        <h3 class="text-blue-800 font-semibold flex items-center">
                        <svg class="w-8 h-8 mr-4 fill-current text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 0H64C29 0 0 29 0 64v384c0 35 29 64 64 64h384c35 0 64-29 64-64V64c0-35-29-64-64-64z" fill="#1976d2"/><path d="M432 256h-80v-64c0-18 14-16 32-16h32V96h-64c-53 0-96 43-96 96v64h-64v80h64v176h96V336h48l32-80z" fill="#fafafa"/></svg>
                        Facebook
                        </h3>
                    </div>

                    <div v-if="socialprovider.facebook=='Enabled'">
                        <div class="w-full sm:flex mt-2">
                            <label for="facebook_redirect" class="block w-full sm:w-1/4 text-sm py-1 ">Redirect URL</label>
                            <div class="text-blue-700 w-full sm:w-3/4 max-w-lg py-1 ">{{ socialProviderRedirectUrl.facebook }}</div>
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
                            @click="changeStatus('twitter', socialprovider.twitter==='Disabled'?'Enabled':'Disabled')">

                            <div class="flex items-center">
                                <div :class="socialprovider.twitter==='Disabled'? 'bg-gray-400':'bg-green-400'" class="rounded-full h-3 w-3 mr-2"></div>
                                <span :class="socialprovider.twitter==='Disabled'? 'text-gray-600':'text-green-600'">{{ socialprovider.twitter }}</span>
                            </div>
                        </div>
                        <h3 class="text-blue-800 font-semibold flex items-center">
                        <svg viewBox="0 0 512 512" class="w-8 h-8 mr-4 fill-current text-blue-400" xmlns="http://www.w3.org/2000/svg"><path d="M512 97c-19 9-39 14-60 17 21-13 38-34 46-58-21 12-43 20-67 25a105 105 0 00-179 96c-87-4-164-46-216-110a106 106 0 0032 140c-17 0-34-5-48-13v2c0 51 37 93 85 103a105 105 0 01-48 1c14 42 52 73 98 74A211 211 0 010 417c46 30 102 47 161 47a297 297 0 00298-312c21-15 39-34 53-55z" fill="#03a9f4"/></svg>
                        Twitter
                        </h3>
                    </div>

                    <div v-if="socialprovider.twitter=='Enabled'">
                        <div class="w-full sm:flex mt-2">
                            <label for="twitter_redirect" class="block w-full sm:w-1/4 text-sm py-1 ">Redirect URL</label>
                            <div class="text-blue-700 w-full sm:w-3/4 max-w-lg py-1 ">{{ socialProviderRedirectUrl.twitter }}</div>
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
                            @click="changeStatus('linkedin', socialprovider.linkedin==='Disabled'?'Enabled':'Disabled')">

                            <div class="flex items-center">
                                <div :class="socialprovider.linkedin==='Disabled'? 'bg-gray-400':'bg-green-400'" class="rounded-full h-3 w-3 mr-2"></div>
                                <span :class="socialprovider.linkedin==='Disabled'? 'text-gray-600':'text-green-600'">{{ socialprovider.linkedin }}</span>
                            </div>
                        </div>
                        <h3 class="text-blue-800 font-semibold flex items-center">
                        <svg viewBox="0 0 512 512" class="w-8 h-8 mr-4 fill-current text-blue-400" xmlns="http://www.w3.org/2000/svg"><path d="M437 0H75C34 0 0 35 0 76v361c0 41 34 75 75 75h362c41 0 75-34 75-75V76c0-41-34-76-75-76zm0 0" fill="#25d9f8"/><path d="M512 76v361c0 41-34 75-75 75H256V0h181c41 0 75 35 75 76zm0 0" fill="#00c0f1"/><g fill="#ececf1"><path d="M121 196h60v211h-60zm0 0M121 106h60v60h-60zm0 0M391 276v131h-60V286c0-16-13-30-30-30s-30 14-30 30v121h-60V196h60v11c16-5 26-11 45-11 41 0 75 37 75 80zm0 0"/></g><path d="M391 276v131h-60V286c0-16-13-30-30-30s-30 14-30 30v121h-15V196h15v11c16-5 26-11 45-11 41 0 75 37 75 80zm0 0" fill="#e2e2e7"/></svg>
                        Linkedin
                        </h3>
                    </div>

                    <div v-if="socialprovider.linkedin=='Enabled'">
                        <div class="w-full sm:flex mt-2">
                            <label for="linkedin_redirect" class="block w-full sm:w-1/4 text-sm py-1 ">Redirect URL</label>
                            <div class="text-blue-700 w-full sm:w-3/4 max-w-lg py-1 ">{{ socialProviderRedirectUrl.linkedin }}</div>
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
                            @click="changeStatus('google', socialprovider.google==='Disabled'?'Enabled':'Disabled')">

                            <div class="flex items-center">
                                <div :class="socialprovider.google==='Disabled'? 'bg-gray-400':'bg-green-400'" class="rounded-full h-3 w-3 mr-2"></div>
                                <span :class="socialprovider.google==='Disabled'? 'text-gray-600':'text-green-600'">{{ socialprovider.google }}</span>
                            </div>
                        </div>
                        <h3 class="text-blue-800 font-semibold flex items-center">
                        <svg viewBox="0 0 512 512" class="w-8 h-8 mr-4 fill-current text-blue-400" xmlns="http://www.w3.org/2000/svg"><path d="M332 150v15a166 166 0 01-332 0A166 166 0 01294 59l-43 43a106 106 0 00-191 63 106 106 0 00202 45h-81v-60zm0 0M512 135v60h-45v45h-60v-45h-45v-60h45V90h60v45zm0 0" fill="#ff3939"/><g fill="#c90232"><path d="M166 60V0c52 0 102 26 128 59l-43 43c-18-24-50-42-85-42zm0 0M332 150v15a166 166 0 01-166 165v-60c42 0 79-25 96-60h-81v-60zm0 0M512 135v60h-45v45h-30V90h30v45zm0 0"/></g></svg>
                        Google
                        </h3>
                    </div>

                    <div v-if="socialprovider.google=='Enabled'">
                        <div class="w-full sm:flex mt-2">
                            <label for="google_redirect" class="block w-full sm:w-1/4 text-sm py-1 ">Redirect URL</label>
                            <div class="text-blue-700 w-full sm:w-3/4 max-w-lg py-1 ">{{ socialProviderRedirectUrl.google }}</div>
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


        <div class="pb-10" v-if="tab=='mail'">

            <p class="text-sm text-gray-700 pb-3 uppercase">Mail Setup</p>

            <div class="rounded w-full">
                <div class="px-6 py-3 mb-4 bg-white shadow rounded">
                    <div>
                        <div class="w-full sm:flex mt-2">
                            <label for="mailDriver" class="block w-full sm:w-1/4 text-sm py-1">Mail Driver</label>
                            <div class="inline-block relative w-64">
                                <select id="mailDriver" v-model="mailDriver" ref="mailDriver" class="block appearance-none w-full bg-white px-2 py-1 pr-8 rounded border focus:outline-none">
                                    <option v-for="mailDriver in mailDrivers" :value="mailDriver.key" :key="mailDriver.key" v-text="mailDriver.value"></option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="w-full sm:flex mt-2">
                            <label for="mailFromAddress" class="block w-full sm:w-1/4 text-sm py-1">Mail From Email</label>
                            <input type="email" id="mailFromAddress" v-model="mailFromAddress" ref="mailFromAddress" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div class="w-full sm:flex mt-2">
                            <label for="mailFromName" class="block w-full sm:w-1/4 text-sm py-1">Mail From Name</label>
                            <input type="text" id="mailFromName" v-model="mailFromName" ref="mailFromName" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>


                        <div v-if="showSmtp" class="w-full sm:flex mt-2">
                            <label for="mailHost" class="block w-full sm:w-1/4 text-sm py-1">Mail Host</label>
                            <input type="text" id="mailHost" v-model="mailHost" ref="mailHost" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div v-if="showSmtp" class="w-full sm:flex mt-2">
                            <label for="mailPort" class="block w-full sm:w-1/4 text-sm py-1">Mail Port</label>
                            <input type="number" id="mailPort" v-model="mailPort" ref="mailPort" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div v-if="showSmtp" class="w-full sm:flex mt-2">
                            <label for="mailEncryption" class="block w-full sm:w-1/4 text-sm py-1">Mail Encryption</label>
                            <div class="inline-block relative w-64">
                                <select id="mailEncryption" v-model="mailEncryption" ref="mailEncryption" class="block appearance-none w-full bg-white px-2 py-1 pr-8 rounded border focus:outline-none">
                                    <option v-for="mailEncryption in mailEncryptions" :value="mailEncryption.key" :key="mailEncryption.key" v-text="mailEncryption.value"></option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div v-if="showSmtp" class="w-full sm:flex mt-2">
                            <label for="mailUsername" class="block w-full sm:w-1/4 text-sm py-1">Mail Username</label>
                            <input type="text" id="mailUsername" v-model="mailUsername" ref="mailUsername" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div v-if="showSmtp" class="w-full sm:flex mt-2 mb-4">
                            <label for="mailPassword" class="block w-full sm:w-1/4 text-sm py-1">Mail Password</label>
                            <div class="w-full block sm:w-3/4 max-w-lg">
                                <input type="text" id="mailPassword" v-model="mailPassword" ref="mailPassword" class="w-full px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                                <p class="mt-3 text-sm" v-show="mailHost.includes('gmail')">
                                    For Gmail, you should not use your regular Gmail password above. Instead, please use App specific password.
                                    Please <a href="https://support.google.com/accounts/answer/185833" target="_blank" class="text-blue-500 hover:underline">follow this link</a>
                                    to obtain your Gmail App Password.
                                </p>
                            </div>
                        </div>


                        <div v-if="showMailgun" class="w-full sm:flex mt-2">
                            <label for="mailgunDomian" class="block w-full sm:w-1/4 text-sm py-1">Mailgun Domain</label>
                            <input type="text" id="mailgunDomian" v-model="mailgunDomian" ref="mailgunDomian" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div v-if="showMailgun" class="w-full sm:flex mt-2">
                            <label for="mailgunSecret" class="block w-full sm:w-1/4 text-sm py-1">Mailgun Secret</label>
                            <input type="text" id="mailgunSecret" v-model="mailgunSecret" ref="mailgunSecret" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div v-if="showMailgun" class="w-full sm:flex mt-2 mb-4">
                            <label for="mailgunEndpoint" class="block w-full sm:w-1/4 text-sm py-1">Mailgun Endpoint</label>
                            <input type="text" id="mailgunEndpoint" v-model="mailgunEndpoint" ref="mailgunEndpoint" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>


                        <div v-if="showPostmark" class="w-full sm:flex mt-2 mb-4">
                            <label for="postmarkToken" class="block w-full sm:w-1/4 text-sm py-1">Postmark Token</label>
                            <input type="text" id="postmarkToken" v-model="postmarkToken" ref="postmarkToken" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>


                        <div v-if="showSes" class="w-full sm:flex mt-2">
                            <label for="sesKey" class="block w-full sm:w-1/4 text-sm py-1">SES Key</label>
                            <input type="text" id="sesKey" v-model="sesKey" ref="sesKey" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div v-if="showSes" class="w-full sm:flex mt-2">
                            <label for="sesSecret" class="block w-full sm:w-1/4 text-sm py-1">SES Secret</label>
                            <input type="text" id="sesSecret" v-model="sesSecret" ref="sesSecret" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                        </div>
                        <div v-if="showSes" class="w-full sm:flex mt-2 mb-4">
                            <label for="sesRegion" class="block w-full sm:w-1/4 text-sm py-1">SES Region</label>
                            <input type="text" id="sesRegion" v-model="sesRegion" ref="sesRegion" class="w-full sm:w-3/4 max-w-lg px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
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

                socialprovider: null,
                socialProviderRedirectUrl: null,
                facebookClientId: null,
                facebookClientSecret: null,
                twitterClientId: null,
                twitterClientSecret: null,
                linkedinClientId: null,
                linkedinClientSecret: null,
                googleClientId: null,
                googleClientSecret: null,

                mailDriver: null,
                mailDrivers: [
                    { key: 'sendmail', value: 'Sendmail' },
                    { key: 'smtp', value: 'SMTP' },
                    { key: 'mailgun', value: 'Mailgun' },
                    { key: 'ses', value: 'Amazon SES' },
                    { key: 'postmark', value: 'Postmark' },
                ],
                mailFromAddress: null,
                mailFromName: null,
                mailHost: null,
                mailPort: null,
                mailEncryption: null,
                mailEncryptions: [
                    { key: '', value: 'NONE' },
                    { key: 'tls', value: 'TLS' },
                    { key: 'ssl', value: 'SSL' },
                ],
                mailUsername: null,
                mailPassword: null,
                mailgunDomian: null,
                mailgunSecret: null,
                mailgunEndpoint: null,
                postmarkToken: null,
                sesKey: null,
                sesSecret: null,
                sesRegion: null,


            }
        },

        created() {

            util.ajax ('get', '/api/parameters/socialprovider', {},  (response) => {
                this.socialprovider = JSON.parse(response)
            })
            util.ajax ('get', '/api/parameters/socialprovider_redirect_url', {},  (response) => {
                this.socialProviderRedirectUrl = JSON.parse(response)
            })

            util.ajax ('get', '/api/settings/social', {},  (response) => {
                this.facebookClientId = response['FACEBOOK_CLIENT_ID']
                this.facebookClientSecret = response['FACEBOOK_CLIENT_SECRET']
                this.twitterClientId = response['TWITTER_CLIENT_ID']
                this.twitterClientSecret = response['TWITTER_CLIENT_SECRET']
                this.linkedinClientId = response['LINKEDIN_CLIENT_ID']
                this.linkedinClientSecret = response['LINKEDIN_CLIENT_SECRET']
                this.googleClientId = response['GOOGLE_CLIENT_ID']
                this.googleClientSecret = response['GOOGLE_CLIENT_SECRET']
            })

            util.ajax ('get', '/api/settings/mail', {},  (response) => {
                this.mailDriver = response['MAIL_DRIVER']
                this.mailFromAddress = response['MAIL_FROM_ADDRESS']
                this.mailFromName = response['MAIL_FROM_NAME']
                this.mailHost = response['MAIL_HOST']
                this.mailPort = response['MAIL_PORT']
                this.mailEncryption = response['MAIL_ENCRYPTION']
                this.mailUsername = response['MAIL_USERNAME']
                this.mailPassword = response['MAIL_PASSWORD']
                this.mailgunDomian = response['MAILGUN_DOMAIN']
                this.mailgunSecret = response['MAILGUN_SECRET']
                this.mailgunEndpoint = response['MAILGUN_ENDPOINT']
                this.postmarkToken = response['POSTMARK_TOKEN']
                this.sesKey = response['AWS_ACCESS_KEY_ID']
                this.sesSecret = response['AWS_SECRET_ACCESS_KEY']
                this.sesRegion = response['AWS_DEFAULT_REGION']
            })

        },


        methods: {

            saveSocialLogin () {
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
                    this.socialprovider.facebook = status
                else if (provider == 'twitter')
                    this.socialprovider.twitter = status
                else if (provider == 'linkedin')
                    this.socialprovider.linkedin = status
                else if (provider == 'google')
                    this.socialprovider.google = status

                util.ajax ('post', '/api/parameters/socialprovider', { "value": JSON.stringify(this.socialprovider) }, function () {
                    util.notifySuccess ('Saved', 'Login provider have been ' + status)
                })
            },

            saveMail () {
                let data = [
                        { 'key': 'MAIL_DRIVER', 'value': this.mailDriver },
                        { 'key': 'MAIL_FROM_ADDRESS', 'value': this.mailFromAddress },
                        { 'key': 'MAIL_FROM_NAME', 'value': this.mailFromName },
                        { 'key': 'MAIL_HOST', 'value': this.mailHost },
                        { 'key': 'MAIL_PORT', 'value': this.mailPort },
                        { 'key': 'MAIL_ENCRYPTION', 'value': this.mailEncryption },
                        { 'key': 'MAIL_USERNAME', 'value': this.mailUsername },
                        { 'key': 'MAIL_PASSWORD', 'value': this.mailPassword },
                        { 'key': 'MAILGUN_DOMAIN', 'value': this.mailgunDomian },
                        { 'key': 'MAILGUN_SECRET', 'value': this.mailgunSecret },
                        { 'key': 'MAILGUN_ENDPOINT', 'value': this.mailgunEndpoint },
                        { 'key': 'POSTMARK_TOKEN', 'value': this.postmarkToken },
                        { 'key': 'AWS_ACCESS_KEY_ID', 'value': this.sesKey },
                        { 'key': 'AWS_SECRET_ACCESS_KEY', 'value': this.sesSecret },
                        { 'key': 'AWS_DEFAULT_REGION', 'value': this.sesRegion },
                    ]

                util.ajax ('post', '/api/settings/mailprovider', { data }, function () {
                    util.notifySuccess ('Saved', 'Mail provider settings have been successfully saved.')
                })
            },

        },


        computed: {
            showSmtp() {
                if (this.mailDriver == 'sendmail' || this.mailDriver == 'smtp') {
                    return true;
                }
                return false;
            },
            showMailgun() {
                if (this.mailDriver == 'mailgun') {
                    return true;
                }
                return false;
            },
            showSes() {
                if (this.mailDriver == 'ses') {
                    return true;
                }
                return false;
            },
            showPostmark() {
                if (this.mailDriver == 'postmark') {
                    return true;
                }
                return false;
            },
        }

    };

</script>
