<template>
    <div>
        <div :class="containerClass">
            <div :class="itemClass" v-for="item in pageData.data" :key="item.id">
                <slot v-bind:item="item"></slot>
            </div>
        </div>

        <div
            v-if="hideNavIfNoNeed && pageData.from === pageData.last_page ? false : true"
            :class="navClass"
        >
            <div v-if="pageData.prev_page_url != null" class="text-center" @click="backPage">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    :class="arrowClass"
                    width="36"
                    height="36"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 8 8 12 12 16"></polyline>
                    <line x1="16" y1="12" x2="8" y2="12"></line>
                </svg>
            </div>

            <div class="text-center flex-grow">
                {{ pageData.current_page }} of {{ pageData.last_page }}
            </div>

            <div v-if="pageData.next_page_url != null" class="text-center" @click="nextPage">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    :class="arrowClass"
                    width="36"
                    height="36"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 16 16 12 12 8"></polyline>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        pageData: {
            type: Object,
            default: () => {},
        },

        hideNavIfNoNeed: {
            type: Boolean,
            default: true,
        },

        containerClass: {
            type: String,
            default: 'w-full md:flex md:flex-wrap md:items-center md:justify-between',
        },

        itemClass: {
            type: String,
            default: 'w-full md:w-1/2 p-4',
        },

        navClass: {
            type: String,
            default: 'w-full mt-4 p-4 flex justify-between items-center',
        },

        arrowClass: {
            type: String,
            default:
                'stroke-current text-blue-500 inline-block h-8 w-8 hover:text-blue-600 cursor-pointer',
        },
    },

    methods: {
        backPage() {
            this.$emit('previous', this.pageData.prev_page_url)
        },

        nextPage() {
            this.$emit('next', this.pageData.next_page_url)
        },
    },
}
</script>
