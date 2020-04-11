<template>

    <div class="max-w-5xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">Templates </h2>
            <a href="/app/templates/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">Create</a>
        </div>


        <div class="px-6 w-full flex justify-between items-center my-8 border-b">
            <div class="flex justify-start">
                <div @click="tab='gallery'" class="-ml-4 px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='gallery'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Gallery
                    <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{ templates.length }}</span>
                </div>

            </div>
            <div v-if="constantLoaded" @click="tab='constants'" class="px-2 text-sm tracking-wide py-2  cursor-pointer" :class="tab==='constants'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">Constants</div>
            <div v-else class="px-2 text-sm tracking-wide text-gray-600 py-2">Loading Constants...</div>
        </div>

        <div class="sm:flex sm:flex-wrap" v-if="tab!='constants'">

            <div v-for="template in templates" class="w-full sm:w-1/2 p-3 lg:p-6">
                <div class="bg-white shadow-lg relative overflow-hidden">
                    <div class="w-full flex justify-right absolute top-0 py-6 px-8">
                        <svg v-if="template.active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 469 469" class="fill-current w-8 h-8 p-1 bg-green-500 text-white text-xs rounded-full shadow-lg font-bold border border-white uppercase"><path d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"/></svg>
                    </div>

                    <div class="block w-full pattern-wall bg-blue-100" style='min-height: 250px; min-width: 400px'>
                        <img v-if="template.media_url !== null" :src="template.media_url"  class="w-full">
                    </div>

                    <div class="w-full p-6 flex flex-col justify-around">

                        <h3 class="text-lg font-bold py-1">
                            {{ template.name }}
                        </h3>

                        <div class="text-sm text-gray-700 py-2 h-20 overflow-hidden">
                            {{ template.description }}
                        </div>

                        <div class="w-full flex items-center">
                            <div class="w-1/2">
                                <a :href="'/app/templates/' + template.id" class="text-blue-600 text-xs rounded py-2 px-6 border border-blue-400">Customize</a>
                            </div>
                            <div class="w-1/2 flex justify-end">
                                <t-button v-if="!template.active" :loadingWheel="isSaving" @click.native="activate(template)" color="blue">
                                    Activate
                                </t-button>
                                <button v-else class="text-xs">This is Active Now</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 pb-10" v-else>

            <p class="text-sm text-gray-700 pb-3 uppercase">Site Information</p>
            <div class="bg-white rounded w-full max-w-21xl p-6 mb-6 shadow">
                <div class="pb-4">
                    <label for="sitename" class="block">Website Name</label>
                    <input type="text" id="sitename" v-model="sitename" ref="sitename" placeholder="My Personal Blog" class="w-full max-w-2xl p-2 my-2 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                    <p class="text-xs text-gray-600">This is a human readable name of your website. <br/>
                    For example, if your website URL is profoundmelon.com, this can be "Profound Melon". <br />
                    </p>
                </div>
                <div class="pb-4">
                    <label for="siteTitle" class="block">Website Title</label>
                    <input type="text" id="siteTitle" v-model="sitetitle" ref="sitetitle" placeholder="My Personal Blog" class="w-full max-w-2xl p-2 my-2 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                    <p class="text-xs text-gray-600">The site title is applicable to your entire site and not specific to a page. Site title is visible in the browser window.
                    <br/>This can be same or different from the <code>sitename</code>.</p>
                </div>
                <div class="pb-4">
                    <label for="sitedesc" class="block">Website Description</label>
                    <textarea id="sitedesc" v-model="sitedesc" ref="sitedesc" placeholder="Daily journals, ideas, viewpoints and photos of Mr. John Doe" class="w-full max-w-2xl p-2 my-2 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"></textarea>
                    <p class="text-xs text-gray-600">Provide a short but accurate description about what this site is about. This information may be utilised by search bots.</p>
                </div>
            </div>

            <t-button :loadingWheel="isSaving" @click.native="saveConstants">
                Save Constants
            </t-button>

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
                tab: 'gallery',
                searchPhrase: '',

                sitetitle: '',
                sitename: '',
                sitedesc: '',

                isSaving: false,
                constantLoaded: false,
            }
        },

        created() {
            util.ajax ('get', '/api/templates', {},  (response) => { this.templates = response })

            util.ajax ('get', '/api/parameters/siteinfo', {},  (response) => {
                let siteinfo = JSON.parse(response)
                this.sitetitle = siteinfo.title
                this.sitename = siteinfo.name
                this.sitedesc = siteinfo.desc

                this.constantLoaded = true
            })

        },


        methods: {

            activate (template) {
                this.isSaving = true

                // deactivate all the templates of same type
                this.templates.map((t) => {
                    if(template.type === t.type) t.active = false
                })

                let p = this

                util.ajax('post', '/api/templates/' + template.id + '/activate', {}, (response) => {
                    template.active = true

                    util.notifySuccess('Template Changed', template.name + ' is now the default template for "' + template.type + '" pages.')

                    p.isSaving = false
                })
            },

            saveConstants () {
                let data = {
                    name: this.sitename,
                    title: this.sitetitle,
                    desc: this.sitedesc,
                }
                util.ajax ('post', '/api/parameters/siteinfo', { "value": JSON.stringify(data) }, function () {
                    util.notifySuccess ('Saved', 'Template constants have been successfully saved.')
                })
            },

        }

    };

</script>
