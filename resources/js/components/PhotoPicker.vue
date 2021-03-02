<template>
    <div :class="containerClasses" @click="showImageBrowser = true">
        <img v-if="!!value" :src="imageUrl" :class="imageClasses" />

        <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            :class="defaultImageClasses"
            width="100"
            height="100"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <circle cx="8.5" cy="8.5" r="1.5"></circle>
            <polyline points="21 15 16 10 5 21"></polyline>
        </svg>

        <t-modal
            :show="showImageBrowser"
            @close="showImageBrowser = false"
            @go-ahead="showImageBrowser = false"
        >
            <template v-slot:header>
                <p class="text-xl text-gray-600 px-6 py-4">Browse Images</p>
            </template>

            <div style="max-height: 300px;" class="px-6 overflow-y-auto border-t">
                <VueImageBrowser
                    :images="photos"
                    :image-properties="imageFields"
                    allow-upload
                    enable-lazy-load
                    save-url="/api/media"
                    post-key="file"
                    :save-request-headers="headers"
                    @selected="onSelect"
                    @saved="onSave"
                    @searched="onSearch"
                >
                </VueImageBrowser>
            </div>

            <template v-slot:action-btn-content>&nbsp;</template>
        </t-modal>
    </div>
</template>

<script>
import VueImageBrowser from '@akashmitra/vue-image-browser'

export default {
    components: {
        VueImageBrowser,
    },

    props: {
        value: {
            type: [Object, String],
            default: null,
        },

        imageList: {
            type: String,
            default: '/api/media',
        },

        containerClasses: {
            type: String,
            default: 'w-full bg-gray-100 flex items-center p-6 border cursor-pointer',
        },

        imageClasses: {
            type: String,
            default: 'block mx-auto border',
        },

        defaultImageClasses: {
            type: String,
            default: 'block mx-auto stroke-current text-gray-500',
        },
    },

    data() {
        return {
            showImageBrowser: false,
            photos: [],
            headers: {
                'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content,
            },
            imageFields: {
                id: 'File ID',
                name: 'Image Name',
                url: 'url',
                size: 'File Size (KB)',
                type: 'Image Type',
                storage: 'Storage Type',
                created_ago: 'Created',
            },
        }
    },

    created() {
        this.getFromServer()
    },

    computed: {
        // This supports sending both object or string as the value prop
        imageUrl() {
            return typeof this.value === 'object' ? this.value.url : this.value
        },
    },

    methods: {
        onSelect(image) {
            this.showImageBrowser = false

            this.$emit('input', typeof this.value === 'object' ? image : image.url)
        },

        onSearch(query) {
            this.getFromServer(query)
        },

        onSave(image) {
            this.photos.unshift(image.file)
        },

        getFromServer(query) {
            const p = this
            let url =
                '/api/media' +
                (typeof query != 'undefined' && query != null
                    ? '?query=' + encodeURIComponent(query)
                    : '')

            util.ajax('GET', url, {}, (response) => {
                p.photos = response.data
            })
        },
    },
}
</script>
