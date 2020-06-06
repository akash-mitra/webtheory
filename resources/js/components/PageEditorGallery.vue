<template>
    <t-modal :show="showGallery" @close="close" @go-ahead="copy">

        <template v-slot:header>
            <p class="text-xl text-gray-600 px-6 py-4">Gallery Images</p>
        </template>

        <div style="max-height: 300px" class="px-6 overflow-y-auto border-t">

            <VueImageBrowser
                :images="photos"
                enable-lazy-load
                allow-upload
                save-url="/api/media"
                :save-request-headers="headers"
                @selected="onSelect"
                @saved="onSave"
                @searched="onSearch">
            </VueImageBrowser>

        </div>

        <template v-slot:action-btn-content>
            <span
                v-show="showCopyBtn"
                class="px-6 py-2 text-white bg-green-600 rounded"
            >
                Copy Image Link
            </span>
        </template>

    </t-modal>

</template>

<script>

import VueImageBrowser from '@akashmitra/vue-image-browser'

export default {
    components: {
        VueImageBrowser,
    },

    props: {
        showGallery: {
            type: Boolean
        },
    },

    data() {
        return {
            photos: [],

            selectedPhoto: null,

            headers: {
                "X-CSRF-Token": document.head.querySelector('meta[name="csrf-token"]').content
            },

            showCopyBtn: false,
        }
    },

    created() {
        this.getFromServer()
    },

    methods: {

        onSelect(image) {

            this.showCopyBtn = true

            this.selectedPhoto = image

        },

        copy() {

            let p = this
            let fqdn = window.location.origin + this.selectedPhoto.url

            if (navigator.clipboard) {
                navigator.clipboard.writeText(fqdn).then(()=>{
                    p.$emit('selected', p.selectedPhoto)
                    p.$emit('close')
                })
            }
        },

        close() {
            this.$emit('close')
        },

        onSearch(query) {
            this.getFromServer(query)
        },

        onSave(image) {

            this.photos.unshift(image.file)
        },

        getFromServer(query) {
            const p = this
            let url = '/api/media' + ((typeof query != 'undefined' && query != null) ? '?query=' + encodeURIComponent(query):'')

            util.ajax(
                'GET',
                url,
                {},
                (response) => {
                    p.photos = response.data
                }
            )
        },

    }
}
</script>
