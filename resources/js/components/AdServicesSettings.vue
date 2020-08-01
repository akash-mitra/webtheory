<template>
    <div class="w-full">
        <div class="bg-white shadow rounded">
            <p class="text-sm px-6 py-4 border-b text-gray-700 uppercase">
                Google Adsense
            </p>

            <div class="sm:flex justify-between">
                <div class="text-sm text-gray-700 p-6">
                    Earn Revenue by showing
                    <a
                        href="https://www.google.com/adsense/start/"
                        target="_blank"
                        class="text-blue-400"
                        >Google Ads</a
                    >
                    inside your pages. Just drop in your Google Adsense Account ID and WebTheory
                    will take care of best ad placements.
                </div>
            </div>

            <div>
                <div class="w-full bg-gray-100 py-4 px-6 shadow-inner border-b border-t">
                    <div class="w-full sm:flex mt-2">
                        <label
                            for="adsense_account_id"
                            class="block w-full sm:w-1/5 mr-4 text-sm py-1"
                            >Adsense Account ID</label
                        >
                        <input
                            type="text"
                            id="adsense_account_id"
                            v-model="adsenseId"
                            ref="adsense_account_id"
                            placeholder="UA-XXXXXXX"
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
            adsenseId: '',

            isUpdating: false,
        }
    },

    created() {
        this.isUpdating = true
        util.ajax('get', '/api/parameters/ad_services', {}, (response) => {
            this.mapResponseData(response)
            this.isUpdating = false
        })
    },

    methods: {
        mapResponseData(response) {
            if (typeof response === 'string') {
                let json = JSON.parse(response)
                this.adsenseId = json.adsense_id
                // this.captchaSecretKey = json.secret_key
            }
        },

        updateSetting() {
            let data = {
                adsense_id: this.adsenseId,
                // secret_key: this.captchaSecretKey,
            }
            this.postToServer(JSON.stringify(data))
        },

        postToServer(data) {
            let p = this
            p.isUpdating = true

            window.axios
                .post('/api/parameters/ad_services', { value: data })
                .then((response) => {
                    util.toast({ icon: 'success', title: 'Ad Services are updated' })
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
