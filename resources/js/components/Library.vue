<template>
    <div class="max-w-4xl mx-auto mb-12">
        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-indigo-600 text-2xl flex items-center">
                <svg
                    class="w-8 h-8 mr-3"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect height="18" rx="2" ry="2" width="18" x="3" y="3"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
                Asset Library
            </h2>
            <library-item-uploader @uploaded="onUpload"></library-item-uploader>
        </div>

        <delayed-search-box :search-status="searchStatus" @searched="onSearch"></delayed-search-box>

        <div class="px-6 w-full flex flex-wrap justify-between items-center my-8">
            <library-item
                v-for="asset in assets"
                :key="asset.id"
                :asset="asset"
                @deleted="onDelete"
            ></library-item>
        </div>
    </div>
</template>

<script>
import LibraryItem from "./LibraryItem";
import DelayedSearchBox from "./DelayedSearchBox";
import LibraryItemUploader from "./LibraryItemUploader";

export default {
    components: {LibraryItem, LibraryItemUploader, DelayedSearchBox},

    data() {
        return {
            assets: [],
            searchPhrase: '',
            searchStatus: '',
        }
    },

    created() {
        this.getFromServer()
    },

    methods: {

        /**
         * Delete the file object from the server.
         * @param item
         */
        onDelete(item) {
            let p = this
            util.ajax('DELETE', '/api/media/' + item.id, {}, () => {
                for (let i = 0; i < p.assets.length; i++) {
                    let photo = p.assets[i]
                    if (photo.id === item.id) {
                        p.assets.splice(i, 1)
                        break
                    }
                }
            })
        },

        /**
         * Begin a new search in the server based on search query.
         * @param query
         */
        onSearch(query) {
            this.searchStatus = 'Searching...'
            this.getFromServer(query)
        },

        onUpload(image) {
            this.assets.unshift(image.file)
        },

        /**
         * Fetch list of files from server.
         * @param query
         */
        getFromServer(query) {
            const p = this
            let url =
                '/api/media' +
                (typeof query != 'undefined' && query != null
                    ? '?query=' + encodeURIComponent(query)
                    : '')

            util.ajax('GET', url, {}, (response) => {
                p.assets = response.data
                p.searchStatus = (response.total === 0) ? 'No record found.' : ''
            })
        },

        log(item) {
            console.log(item)
        },
    },
}
</script>
