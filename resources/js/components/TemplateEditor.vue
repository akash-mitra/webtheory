<template>

    <div class="max-w-5xl mx-auto">

        <div class="px-2 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">Template Editor</h2>
            <t-button :loadingWheel="isSaving" @click.native="initiateSave">
                    Save
            </t-button>
        </div>


        <div class="px-2 w-full flex justify-start items-center mt-8">
            <div @click="tab='template'" class="px-6 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='template'? 'text-gray-700 py-2 1border-b-4 border-blue-500': 'text-gray-500 py-2'">Template</div>
            <div @click="tab='source'" class="px-6 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='source'? 'text-gray-700 py-2 1border-b-4 border-blue-500': 'text-gray-500 py-2'">Source</div>

        </div>

        <div v-show="tab==='template'" class="w-full bg-white px-6 py-10 border-t border-blue-400 rounded mb-12">

            <div class="w-full sm:flex mb-4">
                <label for="templateName" class="block w-full sm:w-1/4 text-sm py-1 px-3">Name</label>
                <input type="text" id="templateName" v-model="name" ref="name" class="w-full sm:w-3/4 max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
            </div>

            <div class="w-full sm:flex mb-8">
                <div class="w-full sm:w-1/4 text-sm py-1 px-3">
                    <label for="templateDescription">Description</label>
                    <p class="text-xs text-gray-600 py-2">Describe the motivation behind this template</p>
                </div>
                <textarea id="templateDescription" v-model="description" class="w-full sm:w-3/4 text-sm max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"></textarea>
            </div>

            <div class="w-full sm:flex mb-8">
                <div class="w-full sm:w-1/4 text-sm py-1 px-3">
                    <p>Type</p>
                    <p class="text-xs text-gray-600 py-2">What kind of blog pages should use this template design?</p>
                </div>
                <div class="w-full sm:w-3/4 flex flex-wrap">
                        <div class="w-40 m-3 p-4 border cursor-pointer rounded-lg shadow-md relative" @click="type='home'" :class="type==='home'? 'bg-green-100 border-green-400':''">
                            <div v-if="type==='home'" class="w-8 h-8 p-2 bg-green-500 text-white rounded-full border border-white" style="position: absolute; top: -10px; right: -10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 469 469" class="fill-current"><path d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"/></svg>
                            </div>
                            <h3 class="text-sm uppercase">Home</h3>
                            <div class="text-xs text-gray-700">Template for the home page of your blog</div>
                        </div>
                        <div class="w-40 h-32 m-3 p-4 border cursor-pointer rounded-lg shadow-md relative" @click="type='single'" :class="type==='single'? 'bg-green-100 border-green-400':''">
                            <div v-if="type==='single'" class="w-8 h-8 p-2 bg-green-500 text-white rounded-full border border-white" style="position: absolute; top: -10px; right: -10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 469 469" class="fill-current"><path d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"/></svg>
                            </div>
                            <h3 class="text-sm uppercase">Single</h3>
                            <div class="text-xs text-gray-700">Template for a single blog article page</div>
                        </div>
                        <div class="w-40 h-32 m-3 p-4 border cursor-pointer rounded-lg shadow-md relative" @click="type='category'" :class="type==='category'? 'bg-green-100 border-green-400':''">
                            <div v-if="type==='category'" class="w-8 h-8 p-2 bg-green-500 text-white rounded-full border border-white" style="position: absolute; top: -10px; right: -10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 469 469" class="fill-current"><path d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"/></svg>
                            </div>
                            <h3 class="text-sm uppercase">Category</h3>
                            <div class="text-xs text-gray-700">Template for showing all the pages from a category</div>
                        </div>
                        <div class="w-40 h-32 m-3 p-4 border cursor-pointer rounded-lg shadow-md relative" @click="type='profile'" :class="type==='profile'? 'bg-green-100 border-green-400':''">
                            <div v-if="type==='profile'" class="w-8 h-8 p-2 bg-green-500 text-white rounded-full border border-white" style="position: absolute; top: -10px; right: -10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 469 469" class="fill-current"><path d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"/></svg>
                            </div>
                            <h3 class="text-sm uppercase">Profile</h3>
                            <div class="text-xs text-gray-700">Template for showing a user profile page</div>
                        </div>
                        <div class="w-40 h-32 m-3 p-4 border cursor-pointer rounded-lg shadow-md relative" @click="type='forum'" :class="type==='forum'? 'bg-green-100 border-green-400':''">
                            <div v-if="type==='forum'" class="w-8 h-8 p-2 bg-green-500 text-white rounded-full border border-white" style="position: absolute; top: -10px; right: -10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 469 469" class="fill-current"><path d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"/></svg>
                            </div>
                            <h3 class="text-sm uppercase">Forum</h3>
                            <div class="text-xs text-gray-700">Template for showing a single forum post</div>
                        </div>
                </div>
            </div>

            <div class="w-full sm:flex mb-4">
                <div class="w-full sm:w-1/4 text-sm py-1 px-3">
                    <label for="templateUrl">Template Image URL</label>
                    <p class="text-xs text-gray-600 py-2">Provide an image URL to be used as template icon image</p>
                </div>

                <div class="w-full sm:w-3/4">
                    <input type="text" id="templateUrl" v-model="url" class="w-full max-w-lg text-sm max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">

                </div>
            </div>
        </div>


        <div v-show="tab==='source'" class="w-full rounded mb-12">
            <editor v-model="sourceCode" @init="editorInit" lang="html" theme="twilight" width="100%" height="500"></editor>
        </div>

    </div>

</template>



<script>

export default {

    data: function () {
        return {
            tab: 'template',
            isSaving: false,

            id: 0,
            type: null,
            name: null,
            description: null,
            url: 'https://source.unsplash.com/500x310/?blog,page',
            sourceCode: null,
            active: false,
        }
    },

    created() {

        this.fetchContentAndLoadEditor()
    },

    components: { editor: require('vue2-ace-editor') },


    methods: {

        editorInit: function () {
            // require('brace/ext/language_tools') //language extension prerequsite...
            require('brace/mode/html')
            // require('brace/mode/javascript')    //language
            // require('brace/mode/less')
            require('brace/theme/twilight')
            // require('brace/snippets/javascript') //snippet
        },

        // simple front-end validations before starting
        // the saving process. Mandatory fields checking.
        isValid: function () {

            if (!this.name) {
                util.notifyError('Template has no name', 'Provide a name for this template')
                return false
            }

            if (this.name.length >= 100) {
                util.notifyError('Template name too long!', 'Keep name within maximum 100 characters.')
                return false
            }

            if (!this.description) {
                util.notifyError('Provide a description', 'Write a few lines of description for this template before saving.')
                return false
            }

            if (this.description.length >= 1048) {
                util.notifyError('Description too long', 'Keep description within about 1000 characters')
                return false
            }


            if (!this.type) {
                util.notifyError('Template must have a type', 'Select any one type for this template, e.g. "Home" or "Single" etc.')
                return false
            }


            return true
        },



        getSaveUrl: function () {
            if (this.id > 0) return '/api/templates/' + this.id
            else return '/api/templates'
        },

        getSaveMethod: function () {
            if (this.id > 0) return 'put'
            else return 'post'
        },

        initiateSave: function () {

            if (this.isValid()) {

                this.isSaving = true


                util.ajax (this.getSaveMethod(), this.getSaveUrl(), {
                    id: this.id,
                    name: this.name,
                    description: this.description,
                    code: this.sourceCode,
                    type: this.type,
                    media_url: this.url,
                    active: this.active
                }, this.postSaveProcessing)

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
                this.$router.replace({ path: '/app/templates/' + id })

            }

            this.isSaving = false

            util.toast({
                icon: 'success',
                titleText: 'Template Saved Successfully',
                // text: 'The page has been saved successfully'
            })

        }, // end of postSaveProcessing

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

                p.sourceCode = 'Retrieving information from the server....'
                // download data from server...
                let p = this
                util.ajax ('get', '/api/templates/' + this.$route.params.id, {}, function (data) {
                    p.id = data.id
                    p.name = data.name
                    p.description = data.description
                    p.type = data.type
                    p.url = data.media_url
                    p.sourceCode = data.code
                    p.active = data.active
                })
            }
        }, // end of fetchContentAndLoadEditor


        deletePage () {

            let p = this
            util.confirm ("Delete this template?", "This action can not be reverted", function () {

                util.ajax ('delete', '/api/templates/' + p.id, {}, (response) => {

                    util.notifySuccess ('Deleted', 'The template has been successfully deleted')

                    p.$router.push('/app/templates')
                })
            })
        },
    }
}
</script>
