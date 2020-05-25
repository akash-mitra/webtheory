<template>

    <div :class="containerClasses" @click="showImageBrowser=true">

        <img
            v-if="!!imageSrc"
            :src="imageSrc"
            class="block mx-auto border"
        >

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
            stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline>
        </svg>


        <t-modal :show="showImageBrowser" @close="showImageBrowser=false" @go-ahead="showImageBrowser=false">

            <template v-slot:header>
                <p class="text-xl text-gray-600 px-6 py-4">Browse Images</p>
            </template>

            <div style="max-height: 300px" class="px-6 overflow-y-auto border-t">

                <VueImageBrowser
                    :source="imageList"
                    selectable
                    @selected="imageSelected"
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
        VueImageBrowser
    },

    props: {

        imageSrc: {
            type: String,
            default: null
        },

        imageList: {
            type: String,
            default: '/api/media'
        },

        containerClasses: {
            type: String,
            default: 'w-full bg-gray-100 flex items-center p-6 border cursor-pointer'
        },

        defaultImageClasses: {
            type: String,
            default: 'block mx-auto stroke-current text-gray-500'
        }
    },

    data() {
        return {
            showImageBrowser: false,
        }
    },

    methods: {

        imageSelected(image) {

            this.showImageBrowser = false

            // this.imageSrc = image.url

            this.$emit('picked', image)
        }
    }

}

</script>