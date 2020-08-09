<template>
    <div>
        <!-- meta tags -->
        <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">Meta Information</div>

        <div class="bg-white rounded md:flex w-full py-6 px-4 border-t-2 border-blue-400 shadow">
            <div class="w-full md:w-1/2 px-4">
                <div class="uppercase1 text-gray-800 text-sm">Meta Description</div>
                <div class="h-20 flex items-center text-xs text-gray-600 overflow-y-scroll">
                    Good meta descriptions are short blurbs that describe accurately the content of
                    the page. This gives Google and other search engines a summary of what the page
                    is about.
                </div>

                <t-error-message :errors="errors" field="metadesc"></t-error-message>

                <textarea
                    name="metadesc"
                    v-model="metadesc"
                    class="mt-2 w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none"
                    :class="!metadesc ? 'border-red-400' : ''"
                ></textarea>
                <span
                    class="mt-3 p-1 text-xs text-blue-700 cursor-pointer hover:text-blue-900"
                    @click="metadesc = intro"
                    >Copy from Intro text</span
                >
            </div>

            <div class="w-full mt-4 md:mt-0 md:w-1/2 px-4">
                <div class="uppercase1 text-gray-800 text-sm">Meta Keywords</div>
                <div class="h-20 flex items-center text-xs text-gray-600 overflow-y-scroll">
                    A series of keywords you deem relevant to the page in question. These are used
                    to automatically generate tags for the page. Note that Google doesn’t use meta
                    keywords in its ranking algorithm.
                </div>

                <t-error-message :errors="errors" field="metakey"></t-error-message>

                <textarea
                    name="metakey"
                    v-model="metakey"
                    class="mt-2 w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none"
                ></textarea>
            </div>
        </div>

        <!-- category selection -->
        <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">Organize</div>

        <div class="bg-white rounded w-full py-6 px-4 border-t-2 border-blue-400 shadow">
            <div class="w-full px-4">
                <div class="uppercase1 text-gray-800 text-sm">Category</div>
                <div class="py-3 flex items-center text-xs text-gray-600 overflow-y-scroll">
                    You may organize your pages under various categories. Category names can be used
                    to create menu items that can link all the pages under the same category.
                </div>

                <div class="inline-block relative w-64">
                    <select
                        id="category_id"
                        v-model="category_id"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option
                            v-for="category in categories"
                            :value="category.key"
                            v-bind:key="category.key"
                        >
                            {{ category.value }}
                        </option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                    >
                        <svg
                            class="fill-current h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of category selection -->

        <!-- search engine preview -->
        <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">Search Engine Preview</div>

        <div class="bg-white rounded w-full py-6 px-4 border-t-2 border-blue-400 shadow">
            <div class="w-full px-4">
                <div class="uppercase1 text-gray-800 text-sm">Google Search Preview</div>
                <div class="py-3 flex items-center text-xs text-gray-600 overflow-y-scroll">
                    This is how this page will appear in Google search when using the page meta
                    description. Search engines may use meta description as snippets for your pages
                    or a more relevant section of your page's visible text, if that fits better with
                    a user's query.
                </div>

                <div class="mt-2 w-full bg-gray-100 rounded-lg p-4 border">
                    <div class="google-header">{{ title }}</div>
                    <div class="google-url">{{ url }}</div>
                    <div class="google-desc">{{ metadesc }}</div>
                </div>
            </div>
        </div>
        <!-- end of search preview -->
    </div>
</template>

<script>
export default {
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

<style>
/**
     * Background color for the icons of "content", "meta", "seetings"
     * during the mobile responsive mode
     */
.bg-icon-primary {
    fill: #a5b3bb;
}

div.ce-paragraph {
    /*
            top and bottom padding must be equal to
            ensure correct positioning of "+"
            sign on left margin
        */
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    padding-left: 0.5rem;
    padding-right: 0.5rem;

    font-size: 1rem;
    line-height: 1.625;
}

h2.ce-header,
h3.ce-header,
h4.ce-header {
    padding-top: 1rem;
    padding-bottom: 0.25rem;
    margin-bottom: 0;
    margin-top: 0;
    font-family: Georgia, Cambria, 'Times New Roman', Times, serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

h2.ce-header {
    font-size: 1.875rem;
    line-height: 1.25;
    font-weight: 600;
    padding-bottom: 1rem;
    padding-top: 1rem;
}

h3.ce-header {
    font-size: 1.875rem;
    line-height: 1.35;
}

h4.ce-header {
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1.375;
    letter-spacing: 0.025em;
    padding-bottom: 0.25rem;
}

li.cdx-list__item {
    padding: 0.3rem 0 0.3rem 0.5rem;
    line-height: 1.625;
}

/**
     * IMAGE BORDER Styles.
     *
     * Disable the original 1px border that comes with editorjs.
     * Create a new 1rem border with shadow.
     */
.image-tool--withBorder div.image-tool__image {
    border-style: none;
}

.image-tool--withBorder img {
    /* equivalent to border p-4 shadow; */

    border: 1px solid #ccc;
    padding: 1rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

/**
     * IMAGE STRETCHED Styles.
     *
     * The image should stretch 100% of the container.
     */
.ce-block--stretched,
.ce-block--stretched img {
    width: 100%;
}

/* On screens that are 768px or more, set the padding */
@media screen and (min-width: 768px) {
    .ce-block--stretched {
        padding-right: 6rem;
        padding-left: 6rem;
    }
}

/**
     * IMAGE BACKGROUND
     *
     * Following css will reprogram the editorjs background
     * to work more like a image centering tool.
     */
.image-tool--withBackground div.image-tool__image {
    /* bg-white p-0; */
    background-color: #fff;
    padding: 0;
}

.image-tool--withBackground img.image-tool__image-picture {
    max-width: 100%;
}

/**
     * IMAGE CAPTION BOX
     *
     * Design for the caption box below image.
     */
.image-tool__caption {
    /* equivalent to bg-gray-100 rounded p-2 shadow-inner border */
    background-color: #f7fafc;
    border-radius: 0.25rem;
    padding: 0.5rem;
    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
    border-width: 1px;
}

/* Right Side Settings Menu
     *
     * Settings menu width.
     */
.ce-settings {
    min-width: 120px;
}

/**
     * CODE BOX
     * Make sure that the code box height is not too high by default
     * Set the height to 100px.
     */
.ce-code__textarea {
    height: 100px;
    min-height: 60px;
}

/*
     * Google SERP styles for Search preview
     */
.google-header {
    font-family: arial, sans-serif;
    font-size: 20px;
    line-height: 1.3;
    cursor: pointer;
    color: #1a0dab;
}

.google-url {
    font-family: arial, sans-serif;
    font-size: 16px;
    line-height: 1.5;
    padding-top: 1px;
    color: #006621;
}

.google-desc {
    line-height: 1.57;
    word-wrap: break-word;
    color: #545454;
    font-family: arial, sans-serif;
    font-size: 14px;
}

/* for autosizing the textareas */
.autoheight {
    resize: none;
    overflow: hidden;
    min-height: 2em;
    max-height: 10em;
}

.bg-pattern {
    background-color: #cbd5e0;
    background-image: url("data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23a0aec0' fill-opacity='0.4' fill-rule='evenodd'%3E%3Cpath d='M5 0h1L0 6V5zM6 5v1H5z'/%3E%3C/g%3E%3C/svg%3E");
}
</style>
