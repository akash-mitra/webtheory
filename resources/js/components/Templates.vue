<template>

    <div class="max-w-5xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">

            <h2 class="text-indigo-600 text-2xl flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                Templates
            </h2>

            <a id="createTemplate" href="/app/templates/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">Create</a>
        </div>


        <div class="px-6 w-full flex justify-between items-center my-8 border-b">

            <div class="flex justify-start">

                <div id="template-installed-tab" @click="tab='installed'" class="-ml-4 px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='installed'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Installed
                    <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{ templates.installed.length }}</span>
                </div>

                <div id="template-available-tab" @click="tab='available'" class="ml-2 px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='available'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Available
                    <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{ templates.available.length }}</span>
                </div>

            </div>

        </div>




        <div class="sm:flex sm:flex-wrap" v-show="tab==='installed'">

            <div v-for="template in templates.installed" class="w-full sm:w-1/2 p-3 lg:p-6">
                <div class="bg-white shadow-lg relative overflow-hidden">
                    <div class="w-full flex justify-right absolute top-0 py-6 px-8">
                        <svg v-if="template.active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 469 469" class="fill-current w-8 h-8 p-1 bg-green-500 text-white text-xs rounded-full shadow-lg font-bold border border-white uppercase"><path d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"/></svg>
                    </div>

                    <div class="block w-full pattern-wall bg-blue-100" style='min-height: 250px; min-width: 400px'>
                        <img v-if="template.media_url !== null" :src="template.media_url"  class="w-full h-64 object-cover">
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
                                <a :id="'customize-template-' + template.id" :href="'/app/templates/' + template.id" class="text-blue-600 text-xs rounded py-2 px-6 border border-blue-400">Customize</a>
                            </div>
                            <div class="w-1/2 flex justify-end">
                                <t-button :id="'activate-template-' + template.name" v-if="!template.active" :loadingWheel="isSaving" @click.native="activate(template)" color="blue">
                                    Activate
                                </t-button>
                                <div v-else class="flex items-center text-green-500">
                                    <svg v-if="template.active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 469 469" class="mr-3 fill-current w-8 h-8 p-1 bg-green-500 text-white text-xs rounded-full shadow-lg font-bold border border-white uppercase"><path d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"/></svg>
                                    Template in Use
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>




        <div class="sm:flex sm:flex-wrap" v-show="tab==='available'">

            <div v-for="template in templates.available" class="w-full sm:w-1/2 p-3 lg:p-6">
                <div class="bg-white shadow-lg relative overflow-hidden">

                    <div class="block w-full pattern-wall bg-blue-100" style='min-height: 250px; min-width: 400px'>
                        <img v-if="template.media_url !== null" :src="template.media_url"  class="w-full h-64 object-cover">
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
                                <span class="px-3 py-1 rounded-lg text-sm bg-gray-200 border">Version {{ template.version }}</span>
                            </div>
                            <div class="w-1/2 flex justify-end">
                                <t-button :id="'install-template-' + template.id" :loadingWheel="isSaving" @click.native="installTemplate(template)" color="blue">
                                    Install Now
                                </t-button>

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
                templates: {
                    installed: [],
                    available: []
                },
                isSaving: false,

                selected: null,
                tab: 'installed',
                searchPhrase: '',
            }
        },

        created() {

            util.ajax ('get', '/api/templates', {},  (response) => { this.templates = response })
        },


        methods: {

            activate (template) {
                this.isSaving = true

                // deactivate all the templates of same type
                this.templates.installed.map((t) => {
                    t.active = false
                })

                let p = this

                util.ajax('post', '/api/templates/' + template.id + '/activate', {}, (response) => {
                    template.active = true

                    util.notifySuccess('Template Changed', template.name + ' is now the default template for "' + template.type + '" pages.')

                    p.isSaving = false
                })
            },


            async installTemplate(template) {

                let p = this

                let result = await Swal.fire({
                    title: 'Save As',
                    input: 'text',
                    inputPlaceholder: 'Copy of ' + template.name,
                    inputValidator: function (value) {
                        return new Promise((resolve) => {
                            if (p.templateNameUnique(value)) {
                                resolve()
                            } else {
                                resolve('This template name already exists')
                            }
                        })
                    }
                })

                if (result.value) {
                        util.ajax ('post', '/api/templates/import', {
                            "from": template.name,
                            "name": result.value
                        }, function (response) {
                            util.notifySuccess ('Installed', 'The new template has been installed successfully')
                            p.templates.installed.push(response)
                        })
                }
                else {
                    console.log('no choice has been given')
                }

            },


            templateNameUnique(name) {

                let found = this.templates.installed.filter(function (template) {
                    return template.name.toUpperCase() === name.toUpperCase()
                })

                return found.length === 0;
            },

        }

    };

</script>
