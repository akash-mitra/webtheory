<template>
    <div class="w-full">
        <div class="w-full flex justify-between">
            <p class="ml-3 text-sm text-gray-700 pb-3 uppercase">Mail Setup</p>
            <button v-if="mailSaved" @click="testMail" class="px-3 py-1 mb-2 mr-2 border border-blue-400 rounded text-blue-500 bg-transparent">Test Email</button>
        </div>

        <div class="rounded w-full">
            <div class="px-6 py-3 border-b bg-white mb-6 rounded">
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

        <t-button :loadingWheel="isSaving" textSize="normal" @click.native="saveMailConfig">
            Save Mail Configuration
        </t-button>

    </div>
</template>

<script>
export default {
    data() {
        return {
            mailSaved: false,
            mailDriver: null,
            mailDrivers: [

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

            isSaving: false,
            isLoading: true,
        }
    },

    created() {

        this.isLoading = true

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

            if (response['MAIL_DRIVER'] != '') {
                this.mailSaved = true
            }

            this.isLoading = false
        })
    },


    methods: {

        saveMailConfig () {

            let p = this
            p.isSaving = true

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

                p.mailSaved = true
                p.isSaving = false
            })

        },

        testMail () {

            window.axios.get('/api/settings/testmail/')
            .then(response => {
                util.notifySuccess ('Success', response.data)
            })
            .catch(error => {
                util.notifyError ('Test Mail Error', error)
            })
        },
    },


    computed: {

        showSmtp() {return this.mailDriver === 'smtp' },

        showMailgun() {return this.mailDriver === 'mailgun' },

        showSes() {return this.mailDriver === 'ses' },

        showPostmark() {return this.mailDriver === 'postmark' },
    }
}
</script>