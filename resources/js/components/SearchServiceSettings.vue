<template>
    <div class="w-full">
        <div class="bg-white shadow rounded">
            <p class="text-sm px-6 py-4 border-b text-gray-700 uppercase">
                Full-Text Search
            </p>

            <div class="sm:flex justify-between">
                <div class="text-sm text-gray-700 p-6">
                    Enable full-text search on every page of your website using Algolia.<br />
                    <a
                        class="text-blue-500 underline"
                        href="https://www.algolia.com/pricing/"
                        target="_blank"
                        >Create Algolia account</a
                    >
                    and provide the API details below.
                </div>
            </div>

            <div>
                <div class="w-full bg-gray-100 py-4 px-6 shadow-inner border-b border-t">
                    <div class="w-full sm:flex mt-2">
                        <label for="appId" class="block w-full sm:w-1/5 mr-4 text-sm py-1"
                            >Enable Search</label
                        >
                        <div class="w-full sm:w-4/5">
                            <t-toggle
                                v-model="enabled"
                                true-value="On"
                                false-value="Off"
                                box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                                :show-value="true"
                            >
                            </t-toggle>
                        </div>
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="appId" class="block w-full sm:w-1/5 mr-4 text-sm py-1"
                            >Algolia APP ID</label
                        >
                        <input
                            type="text"
                            id="appId"
                            v-model="appId"
                            ref="appId"
                            class="w-full sm:w-4/5 max-w-lg px-2 py-1 rounded appearance-none bg-gray-2001 focus:bg-white border focus:outline-none"
                        />
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="appSecret" class="block w-full sm:w-1/5 mr-4 text-sm py-1"
                            >Algolia Secret</label
                        >
                        <input
                            type="text"
                            id="appSecret"
                            v-model="appSecret"
                            ref="appSecret"
                            class="w-full sm:w-4/5 max-w-lg px-2 py-1 rounded appearance-none bg-gray-2001 focus:bg-white border focus:outline-none"
                        />
                    </div>
                    <div class="w-full sm:flex mt-2">
                        <label for="appId" class="block w-full sm:w-1/5 mr-4 text-sm py-1"
                            >Using Community Plan?</label
                        >
                        <t-toggle
                            v-model="communityPlan"
                            true-value="Yes"
                            false-value="No"
                            box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                            true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                            false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                            :show-value="true"
                        >
                        </t-toggle>
                    </div>
                </div>

                <div class="p-6">
                    <t-button
                        :loadingWheel="isUpdating"
                        textSize="normal"
                        @click.native="updateSearchSettings"
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
            enabled: 'Off',
            appId: null,
            appSecret: null,
            communityPlan: 'No',

            isUpdating: false,
        }
    },

    created() {
        this.isUpdating = true

        util.ajax('get', '/api/settings/search', {}, (response) => {
            this.appId = response['ALGOLIA_APP_ID']
            this.appSecret = response['ALGOLIA_SECRET']
            this.communityPlan = response['ALGOLIA_COMMUNITY_PLAN'] === '0' ? 'No' : 'Yes'
            this.enabled = response['SEARCHABLE'] === '0' ? 'Off' : 'On'

            this.isUpdating = false
        })
    },

    methods: {
        updateSearchSettings() {
            let data = {
                ALGOLIA_APP_ID: this.appId,
                ALGOLIA_SECRET: this.appSecret,
                ALGOLIA_COMMUNITY_PLAN: this.communityPlan === 'Yes' ? '1' : '0',
                SEARCHABLE: this.enabled === 'On' ? '1' : '0',
            }

            this.postToServer(data)
        },

        postToServer(data) {
            let p = this
            p.isUpdating = true

            window.axios
                .post('/api/settings/searchprovider', { data: data })
                .then((response) => {
                    util.notifySuccess('Success', response.data)
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
