<template>
    <div class="w-full">
        <div class="bg-white shadow rounded">
            <p class="text-sm px-6 py-4 border-b text-gray-700 uppercase">
                Captcha
            </p>

            <div class="sm:flex justify-between">
                <div class="text-sm text-gray-700 p-6">
                    WebTheory uses reCAPTCHA v3 to detect abusive traffic on your website without
                    any user friction.<br />
                    Get
                    <a
                        class="text-blue-500 underline"
                        href="https://g.co/recaptcha/v3"
                        target="_blank"
                        >reCAPTCHA v3 service key</a
                    >
                </div>
            </div>

            <div>
                <div class="w-full bg-gray-100 py-4 px-6 shadow-inner border-b border-t">
                    <div class="w-full sm:flex mt-2">
                        <label
                            for="captcha_site_key"
                            class="block w-full sm:w-1/5 mr-4 text-sm py-1"
                            >Site Key</label
                        >
                        <input
                            type="text"
                            id="captcha_site_key"
                            v-model="captchaSiteKey"
                            ref="captcha_site_key"
                            class="w-full sm:w-4/5 max-w-lg px-2 py-1 rounded appearance-none bg-gray-2001 focus:bg-white border focus:outline-none"
                        />
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label
                            for="captcha_secret_key"
                            class="block w-full sm:w-1/5 mr-4 text-sm py-1"
                            >Secret Key</label
                        >
                        <input
                            type="text"
                            id="captcha_secret_key"
                            v-model="captchaSecretKey"
                            ref="captcha_secret_key"
                            class="w-full sm:w-4/5 max-w-lg px-2 py-1 rounded appearance-none bg-gray-2001 focus:bg-white border focus:outline-none"
                        />
                    </div>
                </div>

                <div class="p-6">
                    <t-button
                        :loadingWheel="isUpdating"
                        textSize="normal"
                        @click.native="updateSetting"
                    >
                        Save Setting
                    </t-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            captchaSiteKey: '',
            captchaSecretKey: '',
            isUpdating: false,
        }
    },

    created() {
        this.isUpdating = true
        util.ajax('get', '/api/parameters/captcha_service', {}, (response) => {
            this.mapResponseData(response)
            this.isUpdating = false
        })
    },

    methods: {
        mapResponseData(response) {
            if (typeof response === 'string') {
                let json = JSON.parse(response)
                this.captchaSiteKey = json.site_key
                this.captchaSecretKey = json.secret_key
            }
        },

        updateSetting() {
            let data = {
                site_key: this.captchaSiteKey,
                secret_key: this.captchaSecretKey,
            }
            this.postToServer(JSON.stringify(data))
        },

        postToServer(data) {
            let p = this
            p.isUpdating = true

            window.axios
                .post('/api/parameters/captcha_service', { value: data })
                .then((response) => {
                    util.toast({ icon: 'success', title: 'Captch Service Keys are saved' })
                    p.isUpdating = false
                })
                .catch((error) => {
                    util.notifyError('Error', error)
                    p.isUpdating = false
                })
        },
    },
}
</script>
