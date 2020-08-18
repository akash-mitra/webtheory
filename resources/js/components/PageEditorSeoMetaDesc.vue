<template>
    <div>
        <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">Meta Information</div>
        <div class="bg-white rounded md:flex w-full py-6 px-4 border-t-2 border-blue-400 shadow">
            <div class="w-full md:w-1/2 px-4 mb-4">
                <div class="text-gray-800 text-sm mb-4">Meta Description</div>
                <div class="flex items-center text-xs text-gray-600 overflow-y-scroll mb-4">
                    Good meta descriptions are short blurbs that describe accurately the content of
                    the page. This gives Google and other search engines a summary of what the page
                    is about.
                </div>

                <textarea
                    name="value"
                    :value="value"
                    class="w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none"
                    :class="!value ? 'border-red-400' : ''"
                    @input="$emit('input', $event.target.value)"
                ></textarea>
                <span
                    class="mt-3 p-1 text-xs text-blue-700 cursor-pointer hover:text-blue-900"
                    @click="$emit('input', intro)"
                    >Copy from Intro text</span
                >
            </div>
            <div class="w-full md:w-1/2 px-4 mb-4 border-t md:border-none">
                <div class="text-gray-800 text-sm mb-4 mt-4 md:mt-0">Search Engine Preview</div>
                <div class="flex items-center text-xs text-gray-600 overflow-y-scroll mb-4">
                    This is how this page may appear in Google Search Engine Results Page (SERP)
                </div>

                <div class="w-full bg-gray-100 rounded-lg p-4 text-xs">
                    <div class="google-header">{{ title }}</div>
                    <div class="google-url">{{ url }}</div>
                    <div class="google-desc">{{ desc }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title', 'intro', 'value'],

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

        desc() {
            if (!this.value) {
                return ''
            } else {
                return this.value.length > 160 ? this.value.substr(0, 157) + '...' : this.value
            }
        },
    },
}
</script>
<style>
/*
     * Google SERP styles for Search preview
     */
.google-header {
    font-family: arial, sans-serif;
    font-size: 18px;
    line-height: 1.4;
    cursor: pointer;
    color: #1a0dab;
}

.google-url {
    font-family: arial, sans-serif;
    font-size: 14px;
    line-height: 1.4;
    padding-top: 1px;
    color: #006621;
}

.google-desc {
    line-height: 1.5;
    word-wrap: break-word;
    color: #545454;
    font-family: arial, sans-serif;
    font-size: 13px;
}
</style>
