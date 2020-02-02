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
            <Page :page="page" :key="page.id" v-for="page in filteredPages"></Page>
        </div>

    </div>
</template>

<script>

    import { getAuthUserId } from '../auth.js'
    import Page from './Page.vue'

    export default {

        data() {
            return {
                pages: [],
                tab: 'all',
                searchPhrase: ''
            }
        },

        created() {
            util.ajax ('get', '/api/pages', {},  (response) => { this.pages = response })
        },

        components: { Page },

        computed: {
            filteredPages ()
            {
                return this.pages.filter((page) => {

                    if(this.tab === 'draft' && page.status != 'Draft') return false

                    if(this.tab === 'byme' && page.author.id != getAuthUserId()) return false

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
    }

</script>
