<template>
    <div class="w-full my-6 max-w-4xl mx-auto">
        <h2 class="text-indigo-600 text-2xl flex items-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-8 h-8 mr-3"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
            </svg>
            Asset Library
        </h2>

        <VueImageBrowser
            :images="photos"
            :image-properties="imageFields"
            allow-photo-pane
            allow-delete
            allow-upload
            save-url="/api/media"
            enable-lazy-load
            :save-request-headers="headers"
            @saved="onSave"
            @deleted="onDelete"
            @searched="onSearch"
        >
        </VueImageBrowser>
    </div>
</template>

<script>
import VueImageBrowser from '@akashmitra/vue-image-browser'

export default {
    components: {
        VueImageBrowser,
    },
    data() {
        return {
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

    methods: {
        onDelete(image) {
            let p = this
            util.ajax('DELETE', '/api/media/' + image.id, {}, () => {
                for (let i = 0; i < p.photos.length; i++) {
                    let photo = p.photos[i]
                    if (photo.id === image.id) {
                        p.photos.splice(i, 1)
                        break
                    }
                }
            })
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
