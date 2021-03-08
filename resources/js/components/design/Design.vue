<template>
    <div class="max-w-4xl mx-auto">
        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-indigo-600 text-2xl flex items-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 mr-3"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="3" y1="9" x2="21" y2="9"></line>
                    <line x1="9" y1="21" x2="9" y2="9"></line>
                </svg>
                Site Design
            </h2>
            <div class="flex items-center" v-show="tab === 'installed'">
                <FileUploader></FileUploader>

                <a
                    id="createTemplate"
                    href="/app/templates/create"
                    class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow"
                >Create</a
                >
            </div>
        </div>

        <div class="px-6 w-full flex justify-between items-center my-8 border-b">
            <div class="w-full flex justify-between">
                <div class="flex justify-start">
                    <div
                        id="menu-builder-tab"
                        @click="tab = 'menu'"
                        class="-ml-4 px-4 text-sm tracking-wide uppercase cursor-pointer"
                        :class="
                            tab === 'menu'
                                ? 'text-gray-700 py-2 border-b-4 border-blue-500'
                                : 'text-gray-500 py-2'
                        "
                    >
                        Menu
                    </div>

                    <div
                        id="template-installed-tab"
                        @click="tab = 'installed'"
                        class="px-4 text-sm tracking-wide uppercase cursor-pointer"
                        :class="
                            tab === 'installed'
                                ? 'text-gray-700 py-2 border-b-4 border-blue-500'
                                : 'text-gray-500 py-2'
                        "
                    >
                        Templates
                        <span
                            class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300"
                        >{{ templates.installed.length }}</span
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="sm:flex sm:flex-wrap" v-show="tab === 'menu'">

            <MenuBuilder></MenuBuilder>
        </div>


        <div v-show="tab === 'installed'">

            <div class="w-full flex px-6">
                <div class="text-right text-gray-700 text-sm max-w-xs">
                    <div
                        :class="
                            sideTab === 'installed'
                                ? 'text-indigo-500 whitespace-no-wrap'
                                : 'whitespace-no-wrap'
                        "
                        class="w-full pr-8 py-4 cursor-pointer"
                        @click="sideTab = 'installed'"
                    >
                        Installed
                    </div>

                    <div
                        :class="
                            sideTab === 'gallery'
                                ? 'text-indigo-500 whitespace-no-wrap'
                                : 'whitespace-no-wrap'
                        "
                        class="w-full pr-8 py-4 cursor-pointer"
                        @click="sideTab = 'gallery'"
                    >
                        Gallery
                    </div>
                </div>
                <div class="flex-grow border-l">
                    <div class="w-full">
                        <div v-if="sideTab === 'installed'">
                            <div class="sm:flex sm:flex-wrap">
                                <div v-for="i in Array(2).keys()" v-show="isLoading" class="w-full sm:w-1/2 p-3 lg:p-6">
                                    <div class="bg-white shadow-lg relative overflow-hidden">
                                        <div class="h-56 bg-blue-100"></div>
                                        <div class="h-48 bg-white p-6">
                                            <div><span class="text-gray-400 bg-gray-400">Template Name</span></div>
                                            <div class="mt-2">
                                                <span class="text-gray-200 bg-gray-200">
                                                    A detail Template Description goes here, With multiline texts that
                                                    can wrap here
                                                </span>
                                            </div>
                                            <div class="h-8 w-32 border border-blue-200 rounded mt-8"></div>
                                        </div>
                                    </div>
                                </div>

                                <div v-for="template in templates.installed" class="w-full sm:w-1/2 p-3 lg:p-6">
                                    <InstalledTemplateTile :is-saving="isSaving" :template="template"
                                                           @activate="activate(template)"/>
                                </div>
                            </div>
                        </div>
                        <div v-if="sideTab === 'gallery'">
                            <div class="sm:flex sm:flex-wrap">
                                <div v-for="template in templates.available" class="w-full sm:w-1/2 p-3 lg:p-6">
                                    <AvailableTemplateTile :is-saving="isSaving" :template="template"
                                                           @install="installTemplate(template)"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
import FileUploader from './FileUploader.vue'
import MenuBuilder from '../MenuBuilder.vue'
import AvailableTemplateTile from "./AvailableTemplateTile";
import InstalledTemplateTile from "./InstalledTemplateTile";

export default {
    data() {
        return {
            templates: {
                installed: [],
                available: [],
            },
            isSaving: false,

            selected: null,
            tab: 'menu',
            sideTab: 'installed',
            searchPhrase: '',
            isLoading: true,
            templateUploadModal: true,
        }
    },

    components: {
        InstalledTemplateTile,
        AvailableTemplateTile,
        FileUploader,
        MenuBuilder
    },

    created() {
        this.isLoading = true
        util.ajax('get', '/api/templates', {}, (response) => {
            this.templates = response
            this.isLoading = false
        })
    },

    methods: {
        activate(template) {
            this.isSaving = true

            // deactivate all the templates of same type
            this.templates.installed.map((t) => {
                t.active = false
            })

            let p = this

            util.ajax('post', '/api/templates/' + template.id + '/activate', {}, (response) => {
                template.active = true

                util.notifySuccess(
                    'Template Changed',
                    template.name + ' is now the default template for pages.'
                )

                p.isSaving = false
            })
        },

        async installTemplate(template) {
            let p = this
            p.isSaving = true
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
                },
            })

            if (result.value) {
                util.ajax(
                    'post',
                    '/api/templates/import',
                    {
                        from: template.name,
                        name: result.value,
                    },
                    function (response) {
                        util.notifySuccess(
                            'Installed',
                            'The new template has been installed successfully'
                        )
                        p.templates.installed.push(response)
                        p.isSaving = false
                    }
                )
            } else {
                console.log('no choice has been given')
                p.isSaving = false
            }
        },

        templateNameUnique(name) {
            let found = this.templates.installed.filter(function (template) {
                return template.name.toUpperCase() === name.toUpperCase()
            })

            return found.length === 0
        },
    },
}
</script>
