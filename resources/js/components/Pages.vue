<template>

    <div class="max-w-4xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">Pages <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{ pages.length }}</span></h2>
            <a href="/app/pages/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">Create</a>
        </div>

        <div class="px-6">
            <input type="text"
                class="w-full rounded-lg shadow px-4 py-3 text-sm focus:outline-none"
                name="search"
                placeholder="Search by page title, category or author..."
                v-model="searchPhrase"
            />
        </div>


        <div class="px-6 w-full flex justify-start items-center my-8 border-b">
            <div @click="tab='all'" class="px-4 text-sm uppercase cursor-pointer" :class="tab==='all'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">All</div>
            <div @click="tab='draft'" class="px-4 text-sm uppercase cursor-pointer" :class="tab==='draft'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">Draft</div>
            <div @click="tab='byme'" class="px-4 text-sm uppercase cursor-pointer" :class="tab==='byme'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">By Me</div>
        </div>

        <div class="px-6">

            <div v-for="page in filteredPages" class="w-full bg-white shadow border-t border-blue-200 rounded my-4">
                <div class="w-full relative cursor-pointer" @click="openPageEditor(page.id)">
                    <div v-if="page.status==='Draft'" class="absolute top-0 mt-4 right-0 mr-8 px-2 py-1 text-xs text-gray-500 bg-white flex items-center border rounded-lg border-gray-500">draft</div>
                    <h3 class="px-6 pt-4 text-blue-400 text-sm">{{ page.category ? page.category.name : '' }}</h3>
                    <h3 class="px-6 pt-2 text-blue-800 font-semibold text-sm1">{{ page.title }}</h3>
                    <div class="px-6 py-4 text-sm text-gray-600">{{ page.summary }}</div>
                </div>

                <div class="px-6 py-2 bg-gray-100 text-xs flex justify-between items-center" @mouseover="selected = page.id" @mouseleave="selected = null">
                    <div class="mr-4 text-gray-700 flex items-center">
                        <img :src="page.author.avatar" class="h-6 w-6 rounded-full mr-4"/>
                        {{ page.author.name }} updated {{ page.updated_ago }}
                    </div>
                    <div v-show="selected===page.id && page.status != 'Draft'" @click="changeStatus(page, 'Draft')" class="text-blue-600 mr-4 cursor-pointer hover:text-red-600">Unpublish</div>
                    <div v-show="selected===page.id && page.status === 'Draft'" @click="changeStatus(page, 'Live')" class="text-blue-600 mr-4 cursor-pointer hover:text-green-600">Publish</div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    import { getLocalUser } from '../auth.js'

    export default {

        data() {
            return {
                pages: [],
                selected: null,
                tab: 'all',
                searchPhrase: ''
            }
        },

        created() {
            util.ajax ('get', '/api/pages', {},  (response) => { this.pages = response })
        },

        computed: {
            filteredPages () {
                return this.pages.filter((page) => {

                    if(this.tab === 'draft' && page.status != 'Draft') return false

                    if(this.tab === 'byme' && page.author.id != this.authUserId()) return false

                    if(this.tab === 'deleted' && page.deleted_at == null) return false

                    if (!!this.searchPhrase) {
                        let title = page.title.toLowerCase()
                        let summary = page.summary.toLowerCase()
                        let authorName = page.author.name.toLowerCase()
                        let needle = this.searchPhrase.toLowerCase()

                        if (title.indexOf(needle) === -1
                            && summary.indexOf(needle) === -1
                            && authorName.indexOf(needle) === -1)
                                return false
                    }

                    return true
                })
            }
        }, // end of computed

        methods: {

            // opens specific page in editor
            openPageEditor (id) {
                this.$router.push({ path: `/app/pages/${id}` })
            },



            // change the status (Draft / Live) of a specific page
            changeStatus (page, status) {

                util.ajax ('put', '/api/pages/' + page.id + '/status', { "status": status }, (response) => {

                    page.status = status

                    util.toast({
                        icon: 'success',
                        titleText: 'Status Updated',
                        text: ' Page in ' + status + ' mode now.'
                    })
                })
            },

            authUserId () {
                let authUser = getLocalUser()
                if (Object.keys(authUser).length > 0)
                    return authUser.id
                else return -1
            }

        }

    };

</script>

<style scoped>
    p { color: red;}
</style>