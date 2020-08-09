<template>
    <div class="w-full">
        <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">
            Blog Image
        </div>

        <div class="bg-white rounded w-full border-t-2 border-blue-400 shadow">
            <PhotoPicker id="pageImage" v-model="media" image-classes="w-full"></PhotoPicker>
        </div>

        <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">
            Publication
        </div>

        <div class="bg-white rounded w-full border-t-2 border-blue-400 shadow">
            <t-toggle
                id="changeStatus"
                class="pt-6 px-4 mb-4"
                v-model="status"
                true-value="Live"
                false-value="Draft"
                box-class="w-20 shadow-inner bg-gray-100 border rounded-l rounded-r cursor-pointer"
                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                :show-value="true"
            >
            </t-toggle>
            <div class="px-4 w-full mb-4 text-xs text-gray-700">
                Only Live page will be accessible to site visitors.
            </div>

            <div class="flex justify-end p-4 text-right bg-gray-100 border-t">
                <span
                    id="deletePage"
                    @click="deletePage"
                    class="border border-red-500 cursor-pointer text-red-500 hover:text-white px-3 py-2 rounded text-sm hover:bg-red-500"
                >
                    Delete this page
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import PhotoPicker from './PhotoPicker.vue'
export default {
    components: {
        PhotoPicker,
    },
    data: function () {
        return {
            id: 0,
            title: null,
            intro: null,
            contents: [],
            metakey: null,
            metadesc: null,
            category_id: 1,
            media: null,
            status: 'Draft',

            categories: [],

            tab: 'content',
            isSaving: false,
            errors: {
                title: [],
                summary: [],
                metadesc: [],
                metakey: [],
            },

            EDITOR_IDENTITY: 'editorjs',
            showGallery: false,

            timer: null,
            autoSaveFreqSeconds: 60,
        }
    },

    /**--------------------------------------------------------------------------
     * Perform these functions when this component is created
     * for the first time only.
     */
    created: function () {
        //this.fetchContentAndLoadEditor()

        //this.fetchCategoryListFromServer()

        this.timer = window.setInterval(this.autoSave, this.autoSaveFreqSeconds * 1000)
    }, // end of created

    methods: {}, // end of methods

    beforeDestroy() {
        window.clearInterval(this.timer)
    },

    computed: {
        url() {
            return (
                window.location.hostname +
                '/pages/' +
                this.id +
                '-' +
                (!!this.title ? this.title.replace(/\W+/g, '-').toLowerCase() : '')
            )
        },
    },
}
</script>
