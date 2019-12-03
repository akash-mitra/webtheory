<template>

    <div class="w-full" @keydown.cmd.83="processShortcutKey($event)" @keydown.ctrl.83="processShortcutKey($event)">

        

        <div class="w-full px-6 border-b bg-white">

            <div class="max-w-4xl mx-auto flex justify-between items-center">

                <div class="flex justify-start items-center">
                    <div @click="tab='content'" class="pr-6 py-4 text-xs uppercase text-gray-800 cursor-pointer" :class="tab==='content'?'px-6 text-blue-600 font-bold border-b-4 border-blue-500':''">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 sm:hidden"><path class="primary" d="M6 2h6v6c0 1.1.9 2 2 2h6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2zm2 11a1 1 0 0 0 0 2h8a1 1 0 0 0 0-2H8zm0 4a1 1 0 0 0 0 2h4a1 1 0 0 0 0-2H8z"/><polygon class="secondary" points="14 2 20 8 14 8"/></svg>
                        <span class="hidden sm:inline-block tracking-wider">Contents</span>
                    </div>
                    <div @click="tab='meta'" class="px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer" :class="tab==='meta'?'text-blue-600 font-bold border-b-4 border-blue-500':''">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 sm:hidden"><path class="primary" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"/><path class="secondary" d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/></svg>
                        <span class="hidden sm:inline-block tracking-wider">Meta</span>
                    </div>
                    <div @click="tab='setting'" class="px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer" :class="tab==='setting'?'text-blue-600 font-bold border-b-4 border-blue-500':''">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 sm:hidden"><path class="secondary" fill-rule="evenodd" d="M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                        <span class="hidden sm:inline-block tracking-wider">Settings</span>
                    </div>
                </div>
                <t-button v-bind:isLoading="isSaving" @click.native="initiateSave">
                    Save
                </t-button>
            </div>

        </div>



        <!-- content section -->        
        <div v-show="tab==='content'" id="page-contents" class="w-full">

            <div class="pt-10 w-full p-6 pb-24">
                <div class="mx-auto max-w-4xl"> 
                    <label v-show="title.length===0" class="uppercase text-xs tracking-wider text-gray-700 block pb-2">
                        Title
                    </label>
                    
                    <textarea name="title" v-model="title" ref="title" class="bg-transparent border-b-2 border-gray-400 h-24 outline-none text-blue-800 text-3xl tracking-wide w-full" placeholder="Title of your story"></textarea>
                </div>

                <div class="mt-12 mx-auto  max-w-4xl">
                    <label v-show="intro.length===0" class="uppercase text-xs tracking-wider text-gray-700 block pb-2">
                        Intro
                    </label>
                    <textarea name="intro" v-model="intro" class="bg-transparent h-24 outline-none text-gray-700 text-lg tracking-wide w-full" placeholder="Provide a 3/4 lines of introduction to your story..."></textarea>
                </div>
            </div>

            <div class="w-full p-2 bg-gray-100 pb-20">
                <div class="max-w-4xl mx-auto bg-white -mt-16 shadow-xl px-6 pt-6 border-t-2 border-blue-400">
                    <div id="tensor-editor" class="mt-4 mx-auto text-gray-700 py-4 te-typo bg-white -mr-2"></div>  
                </div>
            </div>

        </div>


        <!-- meta section -->
        <div v-show="tab==='meta'" id="page-meta" class="w-full max-w-4xl mx-auto px-4 xl:px-0 pb-20">

            <!-- meta tags -->
            <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">Meta Information</div>

            <div class="bg-white rounded md:flex w-full py-6 px-4 border-t-2 border-blue-400 shadow">

                <div class="w-full md:w-1/2 px-4">
                    <div class="uppercase1 text-gray-800 text-sm">Meta Description</div>
                    <div class="h-20 flex items-center text-xs text-gray-600 overflow-y-scroll">
                        Good meta descriptions are short blurbs that describe accurately the content of the page.
                        This gives Google and other search engines a summary of what the page is about. 
                    </div>

                    <textarea v-model="metadesc" class="mt-2 w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none" :class="metadesc.length === 0 ? 'border-red-400' : ''"></textarea>
                    <span class="mt-3 p-1 text-xs text-blue-700 cursor-pointer hover:text-blue-900" @click="metadesc=intro">Copy from Intro text</span>

                </div>

                <div class="w-full mt-4 md:mt-0 md:w-1/2 px-4">
                    <div class="uppercase1 text-gray-800 text-sm">Meta Keywords</div>
                    <div class="h-20 flex items-center text-xs text-gray-600 overflow-y-scroll">
                        A series of keywords you deem relevant to the page in question. These are used to automatically generate tags for the page.
                        Note that Google doesn’t use meta keywords in its ranking algorithm.
                    </div>
                    <textarea v-model="metakey" class="mt-2 w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none"></textarea>
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
                        <select v-model="category_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <option :value="1" selected='selected'>Uncategorised</option>
                                        
                            <option v-for="category in categories" :value="category.id" v-bind:key="category.id">                        
                                    {{ category.name }}
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



    </div>

</template>

<script>

import EditorJS from '@editorjs/editorjs';

import Header from '@editorjs/header';
import List from '@editorjs/list';
import CodeTool from '@editorjs/code';
import InlineCode from '@editorjs/inline-code';
import Marker from '@editorjs/marker';
import Table from '@editorjs/table';
import ImageTool from '@editorjs/image';
import Embed from '@editorjs/embed';



export default {

    
    data: function () {
        return {
            editor: null,

            id: 0,
            title: '',
            intro: '',
            body: {},
            metakey: '',
            metadesc: '',
            category_id: 1,

            categories: [
                {id: 1, name: 'Orange'},
                {id: 2, name: 'Blue'},
                {id: 3, name: 'Green'},
                {id: 4, name: 'Cyan'},
            ],

            tab: 'content',
            isSaving: false,
        }
    },

    /**--------------------------------------------------------------------------
     * Perform these functions when this component is created 
     * for the first time only.
     */
    created: function () { 

        this.fetchContentDataFromServer()

        



    }, // end of created


    mounted: function () {
        this.focusInput()
    },


    methods: {

        // simple front-end validations before starting
        // the saving process. Mandatory fields checking.
        validateBeforeSave: function () {

            if (this.title.length ===0 
                || this.title.length >= 100
                || this.intro.length ===0 
                || this.intro.length >= 1048)
            return false

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

        initiateSave: function () {

            if (this.validateBeforeSave()) {

                this.isSaving = true

                this.editor
                .save()
                .then((bodyJson) => {
                    let p = this
                    util.ajax (this.getSaveMethod(), this.getSaveUrl(), {
                        id: this.id,
                        title: p.title,
                        summary: p.intro,
                        body_json: JSON.stringify(bodyJson),
                        metakey: p.metakey,
                        metadesc: p.metadesc,
                        category_id: p.category_id
                    }, this.postSaveProcessing)
                    
                }).catch((error) => {
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
                p.id = id

                // change the address bar URL to en edit page url
                p.$router.replace({ path: '/app/pages/' + id })

            } 

                        
            // console.table({
            //     method: p.getSaveMethod(),
            //     url: p.getSaveUrl(),
            //     "ID sent": p.id,
            //     "ID returned": id
            // })
            this.isSaving = false
            
        }, // end of postSaveProcessing

        isJustCreated: function () {
            return this.id === 0
        },

        /**--------------------------------------------------------------------------
         * If the article ID is present (e.g. passed as a URL parameter via router), 
         * then this method will make an AJAX query in the server to fetch the 
         * contents of the article from the database when Vue is created.
         */
        fetchContentDataFromServer: function () {

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
                    p.body = JSON.parse(data.content.body_json)
                    p.editor = p.loadEditorTool()
                })
            } else {
                this.editor = this.loadEditorTool()
            }
        }, // end of fetchContentDataFromServer



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
                        config: {
                            placeholder: 'Enter a sub-heading...'
                        },
                    },

                    // allows you to highlight inline texts
                    marker: Marker,

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
                            rows: 1,
                            cols: 2,
                        },
                    },

                    // allows uploading image via the editor
                    image: {
                        class: ImageTool,
                        config: {
                            endpoints: {
                                byFile: '/server/media/uploadFile', // Backend file uploader endpoint
                                byUrl: '/server/media/fetchUrl',    // Endpoint that provides uploading by Url
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

        focusInput: function () {

            this.$refs.title.focus()
        },

        processShortcutKey: function (event) {
            this.initiateSave()

            if (event) {
                event.preventDefault()
            }
        },


    }, // end of methods

    computed: {
        url: function () {
            return 'https://yoursite.com/' + this.id + '-' + this.title.replace(/\W+/g, '-').toLowerCase(); 
        }
    } 
}
</script>


<style>
.image-tool__caption {
    min-height: 45px
}

.primary {
    fill: #A5B3BB
}

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

</style>

<style lang="scss">
    @import '../../sass/typography.scss';
</style>


