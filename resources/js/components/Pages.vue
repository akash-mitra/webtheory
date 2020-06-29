<template>

    <div class="max-w-4xl mx-auto mb-12">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">Pages</h2>
            <a href="/app/pages/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">Create</a>
        </div>



        <div class="px-6 relative">
            <input type="text"
                class="w-full rounded-lg shadow px-4 py-3 text-sm focus:outline-none"
                name="search"
                placeholder="Search by page title, category or author..."
                v-model="searchPhrase"
                @keyup="doDelayedSearch"
            />
            <span class="absolute inset-y-0 right-0 pr-12 flex items-center text-gray-700">
                {{ searchStatus }}
            </span>
        </div>


        <div class="px-6 w-full flex justify-start items-center my-8 border-b">
            <div id="all-tab" @click="filterByTab('all')" class="px-4 text-sm uppercase cursor-pointer" :class="tab==='all'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">All</div>
            <div id="draft-tab" @click="filterByTab('draft')" class="px-4 text-sm uppercase cursor-pointer" :class="tab==='draft'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">Draft</div>

        </div>

        <div class="px-6">

            <Paginator
                :page-data="paginatedPages"
                @next="fetchFromServer"
                @previous="fetchFromServer"
                container-class="w-full"
                item-class="w-full"
                nav-class="w-full p-4 flex justify-between items-center bg-gray-100"
            >
                <template v-slot:default="data">
                    <Page :page="data.item"></Page>

                </template>
            </Paginator>

            <span class="text-sm text-gray-700">{{ searchStatus }}</span>
        </div>

    </div>
</template>

<script>


    import Page from './Page.vue'
    import Paginator from './Paginator.vue'

    export default {

        data() {
            return {
                paginatedPages: {},
                tab: 'all',
                searchPhrase: '',
                searchStatus: '',
            }
        },

        created() {
            this.fetchFromServer()
        },

        components: {
            Page,
            Paginator,
        },


        methods: {
            fetchFromServer(url) {

                if (typeof url === 'undefined') {
                    url = '/api/pages'
                }

                let oUrl = new URL(url, location.href)

                if (this.tab === 'draft') {
                    oUrl.searchParams.set('type', 'draft')
                }

                oUrl.searchParams.set('query', this.searchPhrase)

                util.ajax ('get', oUrl, {},  (response) => {
                    this.paginatedPages = response
                    this.searchStatus = ''
                })
            },

            doDelayedSearch(evt) {

                evt = (evt) ? evt : window.event;
                let charCode = (evt.which) ? evt.which : evt.keyCode;

                if (charCode === 13 || charCode === 17 || charCode === 18 || charCode === 20 || charCode === 27
                    || charCode === 37 || charCode === 38 || charCode === 39 || charCode === 40) {
                    return
                }

                this.searchStatus = 'Searching...'

                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }

                this.doInstantLocalSearch()

                this.timer = setTimeout(() => this.fetchFromServer(), 500)

            },

            doInstantLocalSearch () {
                    let needle = this.searchPhrase.toLowerCase()
                    for(let i = 0; i < this.paginatedPages.data.length; i++) {
                        let p = this.paginatedPages.data[i]
                        if (
                            (p.title.toLowerCase().indexOf(needle) === -1)
                            && (p.summary.toLowerCase().indexOf(needle) === -1)
                            && (p.author.name.toLowerCase().indexOf(needle) === -1)
                        ) {
                            this.paginatedPages.data.splice(i, 1)
                        }
                    }
            },

            filterByTab(tab) {

                this.tab = tab

                this.fetchFromServer()
            },
        }
    }

</script>
