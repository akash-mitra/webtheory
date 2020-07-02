<template>

    <div class="w-full" @keydown.ctrl.83.exact.prevent.stop="initiateSave">



        <div class="w-full px-6 border-b bg-white">

            <div class="max-w-4xl mx-auto flex justify-between items-center">

                <div class="flex justify-start items-center">
                    <div id="page-content-tab" @click="tab='content'" class="px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer" :class="tab==='content'?'text-blue-600 font-bold border-b-4 border-blue-500':''">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:hidden" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span class="hidden sm:inline-block tracking-wider">Content</span>
                    </div>
                    <div id="page-seo-tab" @click="tab='seo'" class="px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer" :class="tab==='seo'?'text-blue-600 font-bold border-b-4 border-blue-500':''">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:hidden" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg>
                        <span class="hidden sm:inline-block tracking-wider">Seo</span>
                    </div>
                    <div id="page-setting-tab" @click="tab='setting'" class="px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer" :class="tab==='setting'?'text-blue-600 font-bold border-b-4 border-blue-500':''">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:hidden" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span class="hidden sm:inline-block tracking-wider">Setting</span>
                    </div>
                    <div id="page-gallery-tab" @click="showGallery=true" class="px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:hidden" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <span class="hidden sm:inline-block tracking-wider">Gallery</span>
                    </div>
                </div>
                <t-button :loadingWheel="isSaving" @click.native="initiateSave">
                    Save
                </t-button>
            </div>

        </div>



        <!-- content section -->
        <div v-show="tab==='content'" id="page-contents" class="w-full">

            <div class="pt-10 w-full p-6 pb-24">
                <div class="mx-auto max-w-4xl">

                    <label class="px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2">
                        Title
                        <span v-if="!! title" class="bg-gray-100 rounded-lg py-1 px-2 ml-4" :class="title.length>100 ? 'text-red-400': 'text-gray-600'"> {{ title.length }}</span>
                    </label>

                    <textarea name="title" v-model="title" ref="title" class="autoheight h-8 px-6 bg-transparent border-b-2 border-gray-400 outline-none text-blue-800 text-3xl tracking-wide w-full placeholder-gray-700" placeholder="Title of your story" @input="resizeInput($event)"></textarea>

                    <t-error-message :errors="errors" field="title"></t-error-message>

                </div>

                <div class="mt-12 mx-auto  max-w-4xl">

                    <label class="px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2">
                        Intro
                        <span v-if="!! intro" class="bg-gray-100 rounded-lg py-1 px-2 ml-4" :class="intro.length>1048 ? 'text-red-400': 'text-gray-600'"> {{ intro.length }}</span>
                    </label>

                    <textarea name="intro" v-model="intro" ref="intro" class="autoheight h-auto px-6 bg-transparent  outline-none text-gray-700 text-lg tracking-wide w-full placeholder-gray-700" placeholder="Provide a 3/4 lines of introduction to your story..." @input="resizeInput($event)" @focus="resizeInput($event)"></textarea>

                    <t-error-message :errors="errors" field="summary"></t-error-message>

                </div>
            </div>

            <div class="w-full p-2 bg-pattern pb-20">
                <div class="max-w-4xl mx-auto bg-white -mt-16 shadow-xl px-6 pt-12 border-t-2 border-blue-400">
                    <div id="tensor-editor" class="mx-auto text-gray-700 pb-4 bg-white -mr-2 wt-typography"></div>
                </div>
            </div>

        </div>


        <!-- seo section -->
        <div v-show="tab==='seo'" id="page-seo" class="w-full max-w-4xl mx-auto px-4 xl:px-0 pb-20">

            <!-- meta tags -->
            <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">Meta Information</div>

            <div class="bg-white rounded md:flex w-full py-6 px-4 border-t-2 border-blue-400 shadow">

                <div class="w-full md:w-1/2 px-4">
                    <div class="uppercase1 text-gray-800 text-sm">Meta Description</div>
                    <div class="h-20 flex items-center text-xs text-gray-600 overflow-y-scroll">
                        Good meta descriptions are short blurbs that describe accurately the content of the page.
                        This gives Google and other search engines a summary of what the page is about.
                    </div>

                    <t-error-message :errors="errors" field="metadesc"></t-error-message>

                    <textarea name="metadesc" v-model="metadesc" class="mt-2 w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none" :class="!metadesc ? 'border-red-400' : ''"></textarea>
                    <span class="mt-3 p-1 text-xs text-blue-700 cursor-pointer hover:text-blue-900" @click="metadesc=intro">Copy from Intro text</span>

                </div>

                <div class="w-full mt-4 md:mt-0 md:w-1/2 px-4">
                    <div class="uppercase1 text-gray-800 text-sm">Meta Keywords</div>
                    <div class="h-20 flex items-center text-xs text-gray-600 overflow-y-scroll">
                        A series of keywords you deem relevant to the page in question. These are used to automatically generate tags for the page.
                        Note that Google doesn’t use meta keywords in its ranking algorithm.
                    </div>

                    <t-error-message :errors="errors" field="metakey"></t-error-message>

                    <textarea name="metakey" v-model="metakey" class="mt-2 w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none"></textarea>
                </div>
            </div>




            <!-- category selection -->
            <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">Organize</div>

            <div class="bg-white rounded w-full py-6 px-4 border-t-2 border-blue-400 shadow">

                <div class="w-full px-4">
                    <div class="uppercase1 text-gray-800 text-sm">Category</div>
                    <div class="py-3 flex items-center text-xs text-gray-600 overflow-y-scroll">
                        You may organize your pages under various categories.
                        Category names can be used to create menu items that can link all the pages under the same category.
                    </div>

                    <div class="inline-block relative w-64">
                        <select id="category_id" v-model="category_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <option v-for="category in categories" :value="category.key" v-bind:key="category.key">
                                    {{ category.value }}
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>

                </div>
            </div> <!-- end of category selection -->




            <!-- search engine preview -->
            <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">Search Engine Preview</div>

            <div class="bg-white rounded w-full py-6 px-4 border-t-2 border-blue-400 shadow">

                <div class="w-full px-4">
                    <div class="uppercase1 text-gray-800 text-sm">Google Search Preview</div>
                    <div class="py-3 flex items-center text-xs text-gray-600 overflow-y-scroll">
                        This is how this page will appear in Google search when using the page meta description.
                        Search engines may use meta description as snippets for your pages or
                        a more relevant section of your page's visible text, if that fits better with a user's query.
                    </div>

                    <div class="mt-2 w-full bg-gray-100 rounded-lg p-4 border">
                        <div class="google-header">{{title}}</div>
                        <div class="google-url">{{ url }}</div>
                        <div class="google-desc">{{ metadesc }}</div>
                    </div>

                </div>
            </div> <!-- end of search preview -->

        </div><!-- end of meta section -->


        <!-- setting section -->
        <div v-show="tab==='setting'" id="page-setting" class="w-full max-w-4xl mx-auto px-4 xl:px-0 pb-20">

            <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">
                Blog Image
            </div>

            <div class="bg-white rounded w-full border-t-2 border-blue-400 shadow">

                <PhotoPicker
                    id="pageImage"
                    v-model="media"
                    image-classes="w-full"
                ></PhotoPicker>

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
                    <span id="deletePage" @click="deletePage" class="border border-red-500 cursor-pointer text-red-500 hover:text-white px-3 py-2 rounded text-sm hover:bg-red-500">
                        Delete this page
                    </span>

                </div>
            </div>



        </div><!-- end of setting section -->


        <!-- Gallery Section -->
        <PageEditorGallery
            :show-gallery="showGallery"
            @close="showGallery=false"
            @selected="imageSelected"
        ></PageEditorGallery>

    </div>

</template>

<script>

import EditorJS from '@editorjs/editorjs';

import Header from '@editorjs/header';
import List from '@editorjs/list';
import CodeTool from '@editorjs/code';
import InlineCode from '@editorjs/inline-code';
import Marker from '@editorjs/marker';
import Table from '@saurav.mitra/editor-table';

import ImageTool from '@editorjs/image';
import Embed from '@editorjs/embed';

import PhotoPicker from './PhotoPicker.vue';
import PageEditorGallery from './PageEditorGallery.vue';

export default {

    components: {
        PhotoPicker,
        PageEditorGallery
    },

    data: function () {
        return {
            editor: null,

            id: 0,
            title: null,
            intro: null,
            body: {},
            metakey: null,
            metadesc: null,
            category_id: 1,
            media: null,
            status: 'Draft',

            categories: [],

            tab: 'content',
            isSaving: false,
            errors: {
                title: [], summary: [], metadesc: [], metakey: []
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

        this.fetchContentAndLoadEditor()

        this.fetchCategoryListFromServer()

        this.timer = window.setInterval(this.autoSave, this.autoSaveFreqSeconds * 1000)



    }, // end of created


    mounted: function () {
        this.focusInput()

        this.$refs.title.style.height = 'auto';
        this.$refs.intro.style.height = 'auto';

    },


    methods: {

        // simple front-end validations before starting
        // the saving process. Mandatory fields checking.
        isValid: function (showError) {

            if (typeof showError === 'undefined') showError = false

            if (!this.title) {
                (showError) && util.notifyError('Page has no title', 'Provide a title to save this page')
                return false
            }

            if (this.title.length >= 100) {
                (showError) && util.notifyError('Page title too long!', 'Keep page title within maximum 100 characters.')
                return false
            }

            if (!this.intro) {
                (showError) && util.notifyError('Provide an Introduction', 'Write a few lines of intro for this page before saving.')
                return false
            }

            if (this.intro.length >= 1048) {
                (showError) && util.notifyError('Intro too long', 'Keep page intro within about 1000 characters')
                return false
            }


            return true
        },



        getSaveUrl: function () {
            if (this.id > 0) return '/api/pages/' + this.id
            else return '/api/pages'
        },

        getSaveMethod: function () {
            if (this.id > 0) return 'put'
            else return 'post'
        },


        autoSave () {

            this.isValid(false) && this.initiateSave()

        },

        initiateSave: function () {

            if (this.isValid(true)) {

                this.errors = {}

                this.isSaving = true

                this.editor
                .save()
                .then((bodyJson) => {

                    util.ajax (this.getSaveMethod(), this.getSaveUrl(), {
                        id: this.id,
                        title: this.title,
                        summary: this.intro,
                        body_json: JSON.stringify(bodyJson),
                        metakey: this.metakey,
                        metadesc: this.metadesc,
                        category_id: this.category_id,
                        media_id: (!!this.media)? this.media.id : null,
                        status: this.status,
                        editor: this.EDITOR_IDENTITY,
                    },
                    this.postSaveProcessing,
                    this.handle4xxError,
                    this.handle5xxError)
                })
                .catch((error) => {
                    util.toast({
                        icon: 'error',
                        title: "Editor failed. Refresh and try again."
                    })
                    this.isSaving = false

                    console.log('Saving failed: ', error)

                })
            }
        },


        /*--------------------------------------------------------------------------
         * Processes the Id after a successful saving
         */
        postSaveProcessing: function (successResponse) {

            if (this.isJustCreated()) {

                // assign new Id
                let id = parseInt(successResponse.id)
                this.id = id

                // change the address bar URL to en edit page url
                this.$router.replace({ path: '/app/pages/' + id })

            }


            // console.table({
            //     method: p.getSaveMethod(),
            //     url: p.getSaveUrl(),
            //     "ID sent": p.id,
            //     "ID returned": id
            // })
            this.isSaving = false

            util.toast({
                icon: 'success',
                titleText: 'Page Contents are Saved.',
                // text: 'The page has been saved successfully'
            })

        }, // end of postSaveProcessing


        handle4xxError(status, data) {

            this.isSaving = false

            util.notifyError ("Ouch! Couldn't save that...", data.message)

            if (status === 422) {
                this.errors = data.errors
            }
        },

        handle5xxError(status, data) {

            this.isSaving = false

            util.notifyError ("Failed to save the page to server.", data.message)

            console.log(data)
        },

        isJustCreated: function () {
            return this.id === 0
        },

        /**--------------------------------------------------------------------------
         * If the article ID is present (e.g. passed as a URL parameter via router),
         * then this method will make an AJAX query in the server to fetch the
         * contents of the article from the database when Vue is created.
         */
        fetchContentAndLoadEditor: function () {

            if (typeof this.$route.params.id != 'undefined' && parseInt(this.$route.params.id) > 0) {
                // download data from server...
                // console.log('Page Id = ' + this.$route.params.id + ' passed via router param. Downloading contents...')
                let p = this
                util.ajax ('get', '/api/pages/' + this.$route.params.id, {}, function (data) {

                    p.id = data.id
                    p.title = data.title
                    p.intro = data.summary
                    p.metakey = data.metakey
                    p.metadesc = data.metadesc
                    p.category_id = data.category_id
                    p.status = data.status
                    p.media = data.media
                    p.body = JSON.parse(data.content.body_json)
                    p.editor = p.loadEditorTool()
                })
            } else {
                this.editor = this.loadEditorTool()
            }
        }, // end of fetchContentAndLoadEditor


        fetchCategoryListFromServer () {

                let p = this
                util.ajax ('get', '/api/lov/categories', {}, (data) => { p.categories = data })

        }, // end of fetchCategoryListFromServer


        deletePage () {

            let p = this

            util.confirm ("Delete this page?", "This action can not be reverted", function () {

                util.ajax ('delete', '/api/pages/' + p.id, {}, (response) => {

                    util.notifySuccess ('Deleted', 'The page has been successfully deleted')

                    p.$router.push('/app/pages')
                })


            })

        },

        /**--------------------------------------------------------------------------
         * Invokes the Editor and pre-configures the editor with various editor tools
         */
        loadEditorTool: function () {

            return new EditorJS ({

                holder: 'tensor-editor',
                data: this.body,

                tools: {

                    // allows you to insert a header block
                    header: {
                        class: Header,
                        inlineToolbar: true,
                        config: {
                            placeholder: 'Enter a sub-heading...',
                            levels: [2, 3, 4],
                        },
                    },

                    // allows you to highlight inline texts
                    marker: Marker,

                    // imageBrowser: ImageBrowser,

                    // allows you to add a list
                    list: {
                        class: List,
                        inlineToolbar: true,
                    },

                    // allows you to embed code
                    code: CodeTool,

                    inlineCode: InlineCode,

                    // allows you to add table in the text
                    table: {
                        class: Table,
                        config: {
                            rows: 2,
                            cols: 2,
                        },
                    },

                    // allows uploading image via the editor
                    image: {
                        class: ImageTool,
                        config: {
                            endpoints: {
                                byFile: '/api/media', // Backend file uploader endpoint
                                byUrl: '/api/media/fetchUrl',    // Endpoint that provides uploading by Url
                            },
                            additionalRequestHeaders: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                            }
                        }
                    },

                    embed: {
                        class: Embed,
                        inlineToolbar: true,
                        config: {
                            services: {
                                youtube: true,
                                vimeo: true,
                                codepen: true
                            }
                        }
                    }

                } // end of tools

            }) // end of return

        }, // end of loadEditorTool

        focusInput() {

            this.$refs.title.focus()
        },


        resizeInput(e) {
            e.target.style.height = 'auto';
            e.target.style.height = (e.target.scrollHeight)+"px";
        },


        imageSelected(image) {
            //console.log(image)
        },

    }, // end of methods

    beforeDestroy () {

        window.clearInterval(this.timer)
    },


    computed: {
        url() {
            return 'https://yoursite.com/' + this.id
                + '-'
                + (!!this.title ? this.title.replace(/\W+/g, '-').toLowerCase() : '');
        }
    }
}
</script>



<style>

    /**
     * Background color for the icons of "content", "meta", "seetings"
     * during the mobile responsive mode
     */
    .bg-icon-primary {
        fill: #A5B3BB
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

    h2.ce-header, h3.ce-header, h4.ce-header {

        padding-top: 1rem;
        padding-bottom: 0.25rem;
        margin-bottom: 0;
        margin-top: 0;
        font-family: Georgia, Cambria, "Times New Roman", Times, serif;
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
    .ce-block--stretched, .ce-block--stretched img {
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
        font-family: arial,sans-serif;
        font-size: 20px;
        line-height: 1.3;
        cursor: pointer;
        color: #1a0dab
    }

    .google-url {
        font-family: arial,sans-serif;
        font-size: 16px;
        line-height: 1.5;
        padding-top: 1px;
        color: #006621
    }

    .google-desc {
        line-height: 1.57;
        word-wrap: break-word;
        color: #545454;
        font-family: arial,sans-serif;
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
