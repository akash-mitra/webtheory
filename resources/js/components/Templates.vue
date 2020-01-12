<template>

    <div class="max-w-5xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">Templates <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{ templates.length }}</span></h2>
            <a href="/app/templates/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">Create</a>
        </div>


        <div class="px-6 w-full flex justify-start items-center my-8 border-b">
            <div @click="tab='home'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='home'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">Home</div>
            <div @click="tab='category'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='category'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">Category</div>
            <div @click="tab='single'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='single'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">Single</div>
        </div>

        <div class="px-6 sm:flex sm:flex-wrap">

            <div v-for="template in filteredTemplates" class="w-full sm:w-1/2 p-3 lg:p-6">
                <div class="bg-white shadow-lg relative overflow-hidden">
                    <div v-if="template.active" class="w-10 h-10 p-2 bg-green-500 text-white text-xs rounded-full shadow-lg font-bold border border-white uppercase" style="position: absolute; top: 20px; right: 30px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 469 469" class="fill-current"><path d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"/></svg>

                    </div>

                    <img :src="template.media_url" style='min-height: 250px; min-width: 400px' class="w-full">

                    <div class="w-full p-6 flex flex-col justify-around">
                        <h3 class="text-lg font-bold py-1">{{ template.name }}</h3>
                        <div class="text-sm text-gray-700 py-2 h-20 overflow-hidden">
                            {{ template.description }}
                        </div>


                        <div class="w-full flex items-center">

                            <div class="w-1/2">
                                <a :href="'/app/templates/' + template.id" class="text-blue-600">Edit</a>
                            </div>

                            <div class="w-1/2 flex justify-end">
                                <t-button v-if="!template.active" :loadingWheel="isSaving" @click.native="applyTemplate(template)" color="blue">
                                    Apply Now
                                </t-button>
                                <button v-else class="bg-gray-400 text-white text-xs rounded py-2 px-6 shadow cursor-not-allowed">In Use</button>
                            </div>

                        </div>
                    </div>

                </div>


            </div>
        </div>

    </div>
</template>

<script>
    export default {

        data() {
            return {
                templates: [],
                isSaving: false,

                selected: null,
                tab: 'home',
                searchPhrase: ''
            }
        },

        created() {
            //util.ajax ('get', '/api/templates', {},  (response) => { this.templates = response })

            this.templates = [
                {
                    id: 1,
                    name: 'Pristine',
                    type: 'home',
                    description: 'A spotless template that provides a clean and simple user experience for the users of your blog.',
                    media_url: 'https://source.unsplash.com/400x250/?white,blue,ocean,frost',
                    active: true,
                    created: {
                        author: 'Akash Mitra',
                        released: '8 Jan 2020',
                        website: 'example.com'
                    },
                    size: 10,
                    version: 1,
                    repository: null,
                    updatable: true,
                    public: true,
                },
                {
                    id: 2,
                    name: 'Kayana',
                    type: 'home',
                    description: 'Stunningly powerful, elegant and yet rebellious dark template that captures the attention of your readers in a fascinating way.',
                    media_url: 'https://source.unsplash.com/400x250/?dark,elegance,black',
                    active: false,
                    created: {
                        author: 'Akash Mitra',
                        released: '8 Jan 2020',
                        website: 'example.com'
                    },
                    size: 10,
                    version: 1,
                    repository: null,
                    updatable: true,
                    public: true,
                },
                {
                    id: 3,
                    name: 'Spark',
                    type: 'home',
                    description: 'Stunningly powerful, elegant and yet rebellious dark template that captures the attention of your readers in a fascinating way.',
                    media_url: 'https://source.unsplash.com/400x250/?spark,light',
                    active: false,
                    created: {
                        author: 'Akash Mitra',
                        released: '8 Jan 2020',
                        website: 'example.com'
                    },
                    size: 10,
                    version: 1,
                    repository: null,
                    updatable: true,
                    public: true,
                },
            ]
        },

        computed: {

            filteredTemplates () {

                return this.templates.filter(template => {

                    if(this.tab != template.type) return false

                    return true
                })
            }
        }, // end of computed

        methods: {

            // opens specific category in editor
            openCategoryEditor (id) {
                this.$router.push({ path: `/app/pages/${id}` })
            },


            applyTemplate(template) {
                this.isSaving = true

                this.templates.map((template) => {
                    template.active = false
                })

                let p = this

                util.ajax('post', '/api/templates/' + template.id + '/activate', {}, (response) => {
                    template.active = true

                    util.notifySuccess('Template Changed', template.name + ' is now the default template for "' + template.type + '" pages.')

                    p.isSaving = false
                })
            }

        }

    };

</script>
