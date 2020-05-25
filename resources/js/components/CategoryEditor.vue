<template>

    <div class="max-w-5xl mx-auto">

        <div class="px-2 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">
                {{ name || 'Category Editor' }}
            </h2>

            <div>
                <t-button color="gray" @click.native="$router.go(-1)">
                    Close
                </t-button>

                &nbsp;

                <t-button :loadingWheel="isSaving" @click.native="initiateSave">
                    Save
                </t-button>
            </div>
        </div>


        <div class="px-2 w-full flex justify-start items-center mt-8">
            <div @click="tab='category'" class="px-6 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='category'? 'text-gray-700 py-2 1border-b-4 border-blue-500': 'text-gray-500 py-2'">Content</div>
            <div @click="tab='meta'" class="px-6 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='meta'? 'text-gray-700 py-2 1border-b-4 border-blue-500': 'text-gray-500 py-2'">Meta</div>

        </div>

        <div v-show="tab==='category'" class="w-full bg-white px-6 py-10 border-t border-blue-400 rounded mb-12">

            <div class="w-full sm:flex mb-4">
                <label for="categoryName" class="block w-full sm:w-1/4 text-sm py-1 px-3">Name</label>
                <input type="text" id="categoryName" v-model="name" ref="name" class="w-full sm:w-3/4 max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
            </div>

            <div class="w-full sm:flex mb-8">
                <div class="w-full sm:w-1/4 text-sm py-1 px-3">
                    <label for="categoryDescription">Description</label>
                    <p class="text-xs text-gray-600 py-2">Describe the motivation behind this category</p>
                </div>
                <textarea id="categoryDescription" v-model="description" class="w-full sm:w-3/4 text-sm max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"></textarea>
            </div>

            <div class="w-full sm:flex mb-8">
                <div class="w-full sm:w-1/4 text-sm py-1 px-3">
                    <label for="categoryParent">Parent Category</label>
                    <p class="text-xs text-gray-600 py-2">Create this category as a subcategory under parent</p>
                </div>


                <select v-model="parent_id" class="h-10 block w-full sm:w-3/4 max-w-lg px-2 py-1 my-1 text-sm rounded appearance-none1 bg-gray-200 focus:bg-white border focus:outline-none">
                        <option v-for="category in categories" v-bind:value="category.key">
                            {{ category.value }}
                        </option>
                </select>
            </div>

            <hr>
            <div class="w-full sm:flex my-6">
                <div class="w-full sm:w-1/4 text-sm py-1 px-3">
                    <label for="categoryUrl">Optional Image</label>
                    <p class="text-xs text-gray-600 py-2">Provide an image URL to be used as category icon image</p>
                </div>

                <div class="w-full sm:w-3/4">
                    <input type="text" id="categoryUrl" v-model="url" class="w-full max-w-lg text-sm max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">

                </div>
            </div>
        </div>


        <div v-show="tab==='meta'" class="w-full md:flex bg-white px-6 py-10 border-t border-blue-400 rounded mb-12">

                <div class="w-full md:w-1/2 px-4">
                    <div class="uppercase1 text-gray-800 text-sm">Meta Description</div>
                    <div class="h-20 flex items-center text-xs text-gray-600 overflow-y-scroll">
                        The category meta description will be used on category listing pages.
                        Good meta descriptions are short blurbs that describe accurately the content of the page.
                    </div>

                    <textarea v-model="metadesc" class="mt-2 w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none" :class="!metadesc ? 'border-red-400' : ''"></textarea>
                    <span class="mt-3 p-1 text-xs text-blue-700 cursor-pointer hover:text-blue-900" @click="metadesc=description">Copy from category description</span>

                </div>

                <div class="w-full mt-4 md:mt-0 md:w-1/2 px-4">
                    <div class="uppercase1 text-gray-800 text-sm">Meta Keywords</div>
                    <div class="h-20 flex items-center text-xs text-gray-600 overflow-y-scroll">
                        A series of keywords you deem relevant to the category in question.
                        Note that Google doesn’t use meta keywords in its ranking algorithm.
                    </div>
                    <textarea v-model="metakey" class="mt-2 w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none"></textarea>
                </div>

        </div>


        <!--
        <h2 class="mt-4 text-gray-600 text-2xl flex items-center">Pages</h2>
        <div  class="w-full md:flex bg-white px-6 py-10 border-t border-blue-400 rounded my-8">

        </div>
        -->

    </div>

</template>



<script>

export default {

    data: function () {
        return {
            tab: 'category',
            isSaving: false,

            id: 0,
            name: null,
            description: null,
            parent_id: null,
            url: 'https://source.unsplash.com/500x310/?category',
            metadesc: '',
            metakey: '',
            categories: [],
        }
    },

    created() {

        this.fetchContentAndLoadEditor()

        this.fetchCategoriesFromServer()
    },


    methods: {



        // simple front-end validations before starting
        // the saving process. Mandatory fields checking.
        isValid: function () {

            if (!this.name) {
                util.notifyError('Category has no name', 'Provide a name for this category')
                return false
            }

            if (this.name.length >= 100) {
                util.notifyError('Category name too long!', 'Keep name within maximum 100 characters.')
                return false
            }

            if (!this.description) {
                util.notifyError('Provide a description', 'Write a few lines of description for this category before saving.')
                return false
            }

            if (this.description.length >= 1048) {
                util.notifyError('Description too long', 'Keep description within about 1000 characters')
                return false
            }

            return true
        },



        getSaveUrl: function () {
            if (this.id > 0) return '/api/categories/' + this.id
            else return '/api/categories'
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
                    parent_id: this.parent_id,
                    metadesc: this.metadesc,
                    metakey: this.metakey,
                    url: this.url
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

                // change the address bar URL to en edit category url
                this.$router.replace({ path: '/app/categories/' + id })

            }

            this.isSaving = false

            util.toast({
                icon: 'success',
                titleText: 'Category Saved Successfully',
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
                // download data from server...
                let p = this
                util.ajax ('get', '/api/categories/' + this.$route.params.id, {}, function (data) {

                    p.id = data.id
                    p.name = data.name
                    p.description = data.description
                    p.metakey = data.metakey
                    p.metadesc = data.metadesc
                    p.parent_id = data.parent_id
                })
            }

        }, // end of fetchContentAndLoadEditor


        fetchCategoriesFromServer: function () {
            let p = this
            util.ajax ('get', '/api/lov/categories', {}, function(data) {
                // console.table(data)
                p.categories = data
            })
        },

        deletePage () {

            let p = this
            util.confirm ("Delete this category?", "This action can not be reverted", function () {

                util.ajax ('delete', '/api/categories/' + p.id, {}, (response) => {

                    util.notifySuccess ('Deleted', 'The category has been successfully deleted')

                    p.$router.push('/app/categories')
                })
            })
        },
    }
}
</script>
