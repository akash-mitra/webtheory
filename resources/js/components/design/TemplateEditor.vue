<template>
    <div class="max-w-5xl mx-auto px-6">
        <div class="mt-6 pb-4 w-full flex justify-between items-center flex-no-wrap">
            <div>
                <h2 class="text-gray-600 text-2xl capitalize">{{ name }}</h2>
            </div>

            <div class="flex-no-wrap flex">
                <t-button color="white" @click.native="$router.go(-1)">
                    Close
                </t-button>

                &nbsp;

                <t-button :loadingWheel="isSaving" @click.native="initiateSave">
                    Save
                </t-button>
            </div>
        </div>

        <p class="text-gray-700 text-sm py-4 border-b">{{ description }}</p>

        <div class="w-full flex justify-start items-center mt-2">
            <div
                id="template-files-tab"
                @click="tab = 'files'"
                class="px-6 text-sm tracking-wide uppercase cursor-pointer"
                :class="
                    tab === 'files'
                        ? 'text-gray-700 py-2 border-b-4 border-blue-500'
                        : 'text-gray-500 py-2'
                "
            >
                Files
            </div>
            <div
                id="template-parameters-tab"
                @click="tab = 'parameters'"
                class="px-6 text-sm tracking-wide uppercase cursor-pointer"
                :class="
                    tab === 'parameters'
                        ? 'text-gray-700 py-2 border-b-4 border-blue-500'
                        : 'text-gray-500 py-2'
                "
            >
                Parameters
            </div>
            <div
                id="template-general-tab"
                @click="tab = 'general'"
                class="px-6 text-sm tracking-wide uppercase cursor-pointer"
                :class="
                    tab === 'general'
                        ? 'text-gray-700 py-2 border-b-4 border-blue-500'
                        : 'text-gray-500 py-2'
                "
            >
                general
            </div>
        </div>

        <div
            v-show="tab === 'files'"
            class="w-full bg-white px-6 py-6 border-t border-blue-400 overflow-auto mb-12"
        >
            <div class="text-lg text-gray-800 pb-2">Template Files</div>

            <div class="text-sm text-gray-800 pb-4">
                You can edit or add new files for this template. Template files support
                <code>blade</code> syntax.
            </div>

            <table class="table-auto w-full text-sm mb-2">
                <thead>
                    <tr>
                        <th class="pr-2 py-2 border-b text-left">
                            <p>File</p>
                        </th>
                        <th class="hidden md:block pr-2 py-2 border-b text-left">Size in KB</th>
                        <th class="pr-2 py-2 border-b text-left">Updated</th>
                        <th class="pr-2 py-2 border-b text-left"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="file in files">
                        <td
                            :id="'show-file-' + file.identity"
                            class="pr-2 py-2 border-b cursor-pointer text-blue-600"
                            @click="editTemplateFile(file)"
                        >
                            {{ file.name }}
                        </td>
                        <td class="hidden md:block pr-2 py-2 border-b">
                            {{ file.size }}
                        </td>
                        <td class="pr-2 py-2 border-b">
                            {{ file.updated }}
                        </td>
                        <td class="pr-2 py-2 border-b" @click="deleteTemplateFile(file)">
                            <svg
                                class="h-4 w-4 mx-auto block text-gray-500 hover:text-red-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                                ></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </td>
                    </tr>
                </tbody>
            </table>

            <t-button id="addTemplateFile" class="mt-4" color="blue" @click.native="addTemplateFile">Add File</t-button>
        </div>

        <div
            v-show="tab === 'general'"
            class="w-full bg-white border-t border-blue-400 rounded mb-12"
        >
            <div class="w-full sm:flex mb-4 px-6 pt-8">
                <label for="templateName" class="block w-full sm:w-1/4 text-sm py-1 px-3"
                    >Name</label
                >
                <input
                    type="text"
                    id="templateName"
                    v-model="name"
                    ref="name"
                    class="w-full sm:w-3/4 max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                />
            </div>

            <div class="w-full sm:flex mb-8 px-6 py-4">
                <div class="w-full sm:w-1/4 text-sm py-1 px-3">
                    <label for="templateDescription">Description</label>
                    <p class="text-xs text-gray-600 py-2">
                        Describe the motivation and the features of this template
                    </p>
                </div>
                <textarea
                    id="templateDescription"
                    v-model="description"
                    class="w-full sm:w-3/4 text-sm max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                ></textarea>
            </div>

            <div class="w-full sm:flex my-4 border-t px-6 py-6">
                <div class="w-full sm:w-1/4 text-sm py-1 px-3">
                    <label for="templateUrl">Set Parameters</label>
                    <p class="text-xs text-gray-600 py-2">
                        Provide the values for all the below paramters.
                    </p>
                </div>

                <div class="w-full sm:w-3/4">
                    <div
                        v-for="(param, key) in parameters"
                        class="w-full items-center border-b1 p-3"
                    >
                        <div class="w-full">
                            <code class="text-gray-700 p-2 rounded">{{ param.name }}</code>
                        </div>
                        <div class="w-full my-2">
                            <input
                                v-if="param.type === 'text'"
                                type="text"
                                v-model="param.value"
                                class="w-full max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                            />
                            <select
                                v-else
                                v-model="param.value"
                                class="w-full max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                            >
                                <option disabled value="">Select</option>
                                <option
                                    v-for="option in param.options.split(',').map((o) => o.trim())"
                                    :value="option"
                                    >{{ option }}</option
                                >
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full sm:flex border-t px-6 py-6 bg-gray-100">
                <div class="w-full sm:w-1/4 text-sm py-1 px-3">
                    <label for="templateUrl">Template Image URL</label>
                    <p class="text-xs text-gray-600 py-2">
                        Provide an image URL to be used as template icon image
                    </p>
                </div>

                <div class="max-w-lg w-full">
                    <PhotoPicker id="templateImage" v-model="url"></PhotoPicker>
                </div>
            </div>

            <div class="border-t p-6 bg-gray-100 text-right">
                <span
                    v-if="active == 0"
                    class="text-sm text-blue-600 hover:text-red-500 cursor-pointer"
                    @click="deleteTemplate()"
                    >Delete this template</span
                >
                <span v-else class="text-gray-500 text-sm"
                    >Active template can not be deleted.</span
                >
            </div>
        </div>

        <div
            v-show="tab === 'parameters'"
            class="w-full bg-white px-6 py-6 border-t border-blue-400 rounded overflow-auto mb-12"
        >
            <div class="text-lg text-gray-800 pb-2">Create or Edit Template Parameters</div>
            <div class="text-sm text-gray-800 pb-4">
                Parameters are static value(s) that can be used to avoid hard-coding information
                directly in the template and to provide flexibility during template usage.
            </div>
            <table class="table-auto w-full text-xs mb-2">
                <thead>
                    <tr>
                        <th class="pr-2 py-2 border-b text-left">
                            <p>Parameter</p>
                        </th>
                        <th class="pr-2 py-2 border-b text-left">Type</th>
                        <th class="pr-2 py-2 border-b text-left">List Items</th>
                        <th class="pr-2 py-2 border-b text-center">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in parameters">
                        <td class="pr-2 py-2 border-b">
                            <input
                                type="text"
                                v-model="row.name"
                                class="font-mono rounded w-full bg-gray-200 p-2"
                                title="Alphabets, numbers, dash and underscore only"
                                pattern="^[a-zA-Z0-9_-]+(?:_+[a-zA-Z0-9_-]+)*$"
                            />
                        </td>
                        <td class="pr-2 py-2 border-b">
                            <select v-model="row.type" class="text-gray-800 w-full">
                                <option value="text">Text</option>
                                <option value="list">List</option>
                            </select>
                        </td>
                        <td class="pr-2 py-2 border-b">
                            <input
                                v-show="row.type === 'list'"
                                type="text"
                                v-model="row.options"
                                class="font-mono rounded w-full bg-gray-200 p-2"
                            />
                        </td>
                        <td
                            :id="'delete-parameter-' + row.name"
                            class="pr-2 py-2 border-b text-xs cursor-pointer"
                            @click="deleteTemplateParameter(row)"
                        >
                            <svg
                                class="h-4 w-4 mx-auto block text-gray-500 hover:text-red-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                                ></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="text-xs font-normal">No space is allowed in parameter name.</p>
            <div
                id="addTemplateParameter"
                class="py-2 px-4 inline-block mt-4 border rounded cursor-pointer text-sm shado1w border-blue-400 text-blue-500"
                @click="addTemplateParameter"
            >
                Add Parameter
            </div>
        </div>
    </div>
</template>

<script>
import PhotoPicker from '../PhotoPicker.vue'

export default {
    data: function () {
        return {
            tab: 'files',
            isSaving: false,

            id: 0,
            files: [],
            name: null,
            description: null,
            url: 'https://source.unsplash.com/500x310/?blog,page',
            active: false,

            parameters: [
                // {name: "", type: "list", options: "", value: "" },
            ],
        }
    },

    components: {
        PhotoPicker,
    },

    created() {
        this.fetchContentAndLoadEditor()
    },

    methods: {
        addTemplateParameter() {
            this.parameters.push({ name: '', type: 'text', options: '', value: '' })
        },

        deleteTemplateParameter(row) {
            util.confirm(
                'Delete ' + row.name + '?',
                'Before deleting, please make sure no template file is using this parameter',
                () => (this.parameters = this.parameters.filter((param) => param.name != row.name))
            )
        },

        addTemplateFile() {
            this.$router.push({ path: '/app/templates/' + this.id + '/create' })
        },

        editTemplateFile(file) {
            this.$router.push({ path: '/app/templates/' + this.id + '/get/' + file.identity })
        },

        deleteTemplateFile(file) {
            if (this.active) {
                util.notifyInfo(
                    'Template is Active!',
                    'File from active template can not be deleted.'
                )
                return
            }

            let p = this

            util.confirm(
                'Delete Template file?',
                file.name + ' will be removed permanently.',
                function () {
                    util.ajax(
                        'post',
                        '/api/templates/' + p.id + '/remove',
                        {
                            name: file.identity,
                        },
                        function (response) {
                            p.files = p.files.filter((f) => f.identity != file.identity)

                            util.toast({ icon: 'success', title: 'File deleted successfully' })
                        }
                    )
                }
            )
        },

        // simple front-end validations before starting
        // the saving process. Mandatory fields checking.
        isValid: function () {
            if (!this.name) {
                util.notifyError('Template has no name', 'Provide a name for this template')
                return false
            }

            if (this.name.length >= 100) {
                util.notifyError(
                    'Template name too long!',
                    'Keep name within maximum 100 characters.'
                )
                return false
            }

            if (!this.description) {
                util.notifyError(
                    'Provide a description',
                    'Write a few lines of description for this template before saving.'
                )
                return false
            }

            if (this.description.length >= 1048) {
                util.notifyError(
                    'Description too long',
                    'Keep description within about 1000 characters'
                )
                return false
            }

            return true
        },

        getSaveUrl: function () {
            if (this.id > 0) return '/api/templates/' + this.id
            else return '/api/templates'
        },

        getSaveMethod: function () {
            if (this.id > 0) return 'patch'
            else return 'post'
        },

        initiateSave: function () {
            if (this.isValid()) {
                this.isSaving = true

                util.ajax(
                    this.getSaveMethod(),
                    this.getSaveUrl(),
                    {
                        id: this.id,
                        name: this.name,
                        description: this.description,
                        media_url: this.url,
                        active: this.active,
                        parameters: JSON.stringify(this.parameters),
                    },
                    this.postSaveProcessing
                )
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
            if (
                typeof this.$route.params.id != 'undefined' &&
                parseInt(this.$route.params.id) > 0
            ) {
                let p = this
                util.ajax('get', '/api/templates/' + this.$route.params.id, {}, function (data) {
                    p.id = data.id
                    p.name = data.name
                    p.description = data.description
                    p.files = data.files
                    p.url = data.media_url
                    p.active = data.active
                    p.parameters = JSON.parse(data.parameters)
                })
            }
        }, // end of fetchContentAndLoadEditor

        deleteTemplate() {
            let p = this
            util.confirm('Delete this template?', 'This action can not be reverted', function () {
                util.ajax('delete', '/api/templates/' + p.id, {}, (response) => {
                    util.notifySuccess('Deleted', 'The template has been successfully deleted')

                    p.$router.push('/app/design')

                })
            })
        },
    },
}
</script>
