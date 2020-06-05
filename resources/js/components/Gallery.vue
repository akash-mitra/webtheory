<template>
    <div class="w-full my-6 max-w-4xl mx-auto">

         <h2 class="text-gray-600 text-2xl flex items-center">
                Media Gallery
        </h2>

        <VueImageBrowser
            :images="photos"
            :image-properties="imageFields"
            allow-select
            allow-upload
            :allow-delete="true"
            enable-lazy-load
            save-url="/api/media"
            :save-request-headers="headers"
            @selected="onSelect"
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
                "X-CSRF-Token": document.head.querySelector('meta[name="csrf-token"]').content
            },
            imageFields: {
                'id': 'File ID',
                'name': 'Image Name',
                'url': 'url',
                'size': 'File Size (KB)',
                'type': 'Image Type',
                'storage': 'Storage Type',
                'created_ago': 'Created'
            }
        }
    },

    created() {
        this.getFromServer()
    },

    methods: {
        onDelete(image) {
            let p = this
            util.ajax(
                'DELETE',
                '/api/media/' + image.id,
                {},
                () => {
                    for(let i = 0; i < p.photos.length; i++) {
                        let photo = p.photos[i]
                        if (photo.id === image.id){
                                p.photos.splice(i, 1)
                                break
                        }
                    }
                }
            )
        },

        onSelect(image) {
            console.log('on select', image)
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
