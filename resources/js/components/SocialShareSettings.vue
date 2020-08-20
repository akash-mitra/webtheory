<template>
    <div class="w-full">
        <div class="bg-white shadow rounded">
            <p class="text-sm px-6 py-4 border-b text-gray-700 uppercase">
                Social Sharing
            </p>

            <div class="sm:flex justify-between">
                <div class="text-sm text-gray-700 p-6">
                    Easily enable or disable Social Media sharing for the pages you create.
                </div>
            </div>

            <div>
                <div class="w-full bg-gray-100 shadow-inner border-b border-t">
                    <div class="w-full flex py-3 px-6 border-b">
                        <div class="">
                            <t-toggle
                                v-model="share.facebook_share"
                                true-value="On"
                                false-value="Off"
                                box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                                :show-value="true"
                            >
                            </t-toggle>
                        </div>
                        <label class="block ml-6 text-sm py-1">Facebook Share Button</label>
                    </div>

                    <div class="w-full flex py-3 px-6 border-b">
                        <div class="">
                            <t-toggle
                                v-model="share.twitter_post"
                                true-value="On"
                                false-value="Off"
                                box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                                :show-value="true"
                            >
                            </t-toggle>
                        </div>
                        <label class="block ml-6 text-sm py-1">Twitter Post Button</label>
                    </div>

                    <div class="w-full flex py-3 px-6 border-b">
                        <div class="">
                            <t-toggle
                                v-model="share.pinterest_pin"
                                true-value="On"
                                false-value="Off"
                                box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                                :show-value="true"
                            >
                            </t-toggle>
                        </div>
                        <label class="block ml-6 text-sm py-1">Pinterest Pin</label>
                    </div>

                    <div class="w-full flex py-3 px-6 border-b">
                        <div class="">
                            <t-toggle
                                v-model="share.linkedin_post"
                                true-value="On"
                                false-value="Off"
                                box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                                :show-value="true"
                            >
                            </t-toggle>
                        </div>
                        <label class="block ml-6 text-sm py-1">LinkedIn Post</label>
                    </div>

                    <div class="w-full flex py-3 px-6 border-b">
                        <div class="">
                            <t-toggle
                                v-model="share.whatsapp_send"
                                true-value="On"
                                false-value="Off"
                                box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                                :show-value="true"
                            >
                            </t-toggle>
                        </div>
                        <label class="block ml-6 text-sm py-1">WhatsApp Send</label>
                    </div>

                    <div class="w-full flex py-3 px-6 border-b">
                        <div class="">
                            <t-toggle
                                v-model="share.reddit_share"
                                true-value="On"
                                false-value="Off"
                                box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                                :show-value="true"
                            >
                            </t-toggle>
                        </div>
                        <label class="block ml-6 text-sm py-1">Reddit Share Button</label>
                    </div>

                    <div class="w-full flex py-3 px-6 border-b">
                        <div class="">
                            <t-toggle
                                v-model="share.tumblr_share"
                                true-value="On"
                                false-value="Off"
                                box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                                :show-value="true"
                            >
                            </t-toggle>
                        </div>
                        <label class="block ml-6 text-sm py-1">Tumblr Share Button</label>
                    </div>
                </div>

                <div class="p-6">
                    <t-button
                        :loadingWheel="isUpdating"
                        textSize="normal"
                        @click.native="postToServer"
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
            share: {
                facebook_share: 'Off',
                twitter_post: 'Off',
                pinterest_pin: 'Off',
                linkedin_post: 'Off',
                whatsapp_send: 'Off',
                reddit_share: 'Off',
                tumblr_share: 'Off',
            },
            isUpdating: false,
        }
    },

    created() {
        let p = this
        this.isUpdating = true

        util.ajax('get', '/api/parameters/share', {}, (response) => {
            if (response) {
                try {
                    p.share = JSON.parse(response)
                } catch (e) {
                    // console.log(e)
                }
            }

            p.isUpdating = false
        })
    },

    methods: {
        postToServer() {
            let p = this
            this.isUpdating = true

            window.axios
                .post('/api/parameters/share', { value: JSON.stringify(this.share) })
                .then((response) => {
                    util.notifySuccess('Saved', 'Successfully saved Social Media Sharing Settings.')
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
