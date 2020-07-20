<template>
    <div class="max-w-4xl mx-auto">
        <div class="px-6 py-4 text-indigo-600 text-2xl flex items-center justify-between">
            <div class="flex items-center justify-start">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8 mr-3"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path
                        d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"
                    ></path>
                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                </svg>
                <div>
                    {{ form.name }}
                </div>
            </div>
            <div class="flex">
                <div
                    @click="$router.push({ name: 'forms.index' })"
                    class="h-10 text-blue-500 text-sm px-4 py-2 border border-blue-500 rounded cursor-pointer mr-3"
                >
                    Close
                </div>
                <div
                    @click="saveForm"
                    class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow cursor-pointer"
                >
                    Save Form
                </div>
            </div>
        </div>
        <div class="px-6">
            {{ form.description }}
        </div>

        <div class="px-6 w-full flex justify-start items-center mt-8 border-b">
            <div
                id="general"
                @click="tab = 'general'"
                class="px-4 text-sm uppercase cursor-pointer"
                :class="
                    tab === 'general'
                        ? 'text-gray-700 py-2 border-b-4 border-blue-500'
                        : 'text-gray-500 py-2'
                "
            >
                General
            </div>

            <div
                id="fields"
                @click="tab = 'fields'"
                class="px-4 text-sm uppercase cursor-pointer"
                :class="
                    tab === 'fields'
                        ? 'text-gray-700 py-2 border-b-4 border-blue-500'
                        : 'text-gray-500 py-2'
                "
            >
                Fields
                <span class="px-2 py-1 ml-3 bg-gray-300 text-white1 rounded">{{
                    this.form.fields.length
                }}</span>
            </div>

            <div
                id="responses"
                @click="tab = 'responses'"
                class="px-4 text-sm uppercase cursor-pointer"
                :class="
                    tab === 'responses'
                        ? 'text-gray-700 py-2 border-b-4 border-blue-500'
                        : 'text-gray-500 py-2'
                "
            >
                Responses
            </div>
        </div>

        <div v-if="tab === 'fields'" class="px-6">
            <div v-for="(field, index) in form.fields" :key="index">
                <FormEditorField
                    :field="field"
                    class="bg-white border rounded my-6"
                    @delete="deleteField(index)"
                ></FormEditorField>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded my-3" @click="addField">
                Add New Field
            </button>
        </div>

        <div
            v-if="tab === 'general'"
            class="px-6 bg-white py-4 grid grid-cols-1 md:grid-cols-3 gap-4"
        >
            <div class="col-span-2 md:border-r">
                <label class="block pb-2 text-gray-600 mt-4 text-sm">Form Name</label>
                <input
                    v-model="form.name"
                    class="w-full bg-gray-100 rounded max-w-lg border px-4 py-2"
                />
                <label class="block pb-2 text-gray-600 mt-4 text-sm">Description</label>
                <textarea
                    v-model="form.description"
                    class="w-full max-w-lg border bg-gray-100 rounded px-4 py-2"
                ></textarea>

                <label class="block pb-2 text-gray-600 mt-4 text-sm">Status</label>
                <t-toggle
                    v-model="form.status"
                    true-value="Live"
                    false-value="Draft"
                    class="w-20"
                    box-class="w-20 inline shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                    true-class="h-6 px-3 bg-green-500 text-blue-100 rounded shadow-sm"
                    false-class="h-6 px-3 bg-gray-500 text-white rounded shadow-sm"
                    :show-value="true"
                >
                </t-toggle>

                <label class="block pb-2 text-gray-600 mt-4 text-sm">Spam Protection</label>
                <t-toggle
                    v-model="spamProtect"
                    class="w-20"
                    true-value="On"
                    false-value="Off"
                    box-class="w-20 inline shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                    true-class="h-6 px-3 bg-green-500 text-blue-100 rounded shadow-sm"
                    false-class="h-6 px-3 bg-gray-500 text-white rounded shadow-sm"
                    :show-value="true"
                >
                </t-toggle>
            </div>
            <div class="col-span-1 md:px-4 py-4 text-sm" v-if="form.id > 0">
                <div class="font-bold">Embed</div>
                <div class="">
                    To embed the form directly in template files, use below code. <br />
                    <code class="text-red-700 bg-red-100 p-1">@form(['id' => {{ form.id }}])</code>
                </div>
                <div class="font-bold mt-3">API Endpoint</div>
                <div class="">
                    You may post the form data manually to be below URL. <br />
                    <code class="text-red-700 bg-red-100 p-1"
                        >/api/forms/{{ form.id }}/response</code
                    >
                </div>
            </div>
        </div>

        <div v-if="tab === 'general'" class="px-6 bg-gray-100 mt-41 py-4 flex justify-end">
            <span class="text-sm text-red-500 py-2 cursor-pointer" @click="deleteForm"
                >Delete Form</span
            >
        </div>

        <div v-if="tab === 'responses' && form.hasOwnProperty('id')" class="px-6">
            <FormResponses :form="form.id"></FormResponses>
        </div>

        <div class="py-4"></div>
    </div>
</template>

<script>
import FormEditorField from './FormEditorField.vue'
import FormResponses from './FormResponses.vue'

export default {
    data() {
        return {
            form: {
                name: 'New Form',
                description: '',
                status: 'Live',
                fields: [
                    {
                        name: 'Add New Field',
                        type: 'text',
                        desc: '',
                        placeholder: '',
                        validation: 'required',
                        default: '',
                        options: [],
                    },
                ],
            },
            spamProtect: 'On',
            isSaving: true,
            responses: null,
            tab: 'general',
        }
    },

    components: {
        FormEditorField,
        FormResponses,
    },

    created() {
        if (typeof this.$route.params.id != 'undefined' && parseInt(this.$route.params.id) > 0) {
            util.ajax(
                'get',
                '/api/forms/' + this.$route.params.id,
                {},
                (response) => {
                    this.form = response
                    this.form.fields = JSON.parse(this.form.fields)
                    this.spamProtect = this.form.captcha ? 'On' : 'Off'
                    this.isSaving = false
                },
                (error) => {
                    if (error === 404) {
                        util.notifySuccess(
                            'Not Found',
                            'No form found for this url. Taking you back to form list'
                        )
                        this.$router.push('/app/forms')
                    }
                }
            )
        }
    },

    methods: {
        getSaveUrl: function () {
            if (this.form.id > 0) return '/api/forms/' + this.form.id
            else return '/api/forms'
        },

        getSaveMethod: function () {
            if (this.form.id > 0) return 'put'
            else return 'post'
        },

        isJustCreated: function () {
            return !(this.form.hasOwnProperty('id') && this.form.id > 0)
        },

        saveForm() {
            //console.log(this.getSaveMethod())
            this.isSaving = true
            util.ajax(
                this.getSaveMethod(),
                this.getSaveUrl(),
                {
                    name: this.form.name,
                    description: this.form.description,
                    status: this.form.status || 'Draft',
                    captcha: this.spamProtect === 'On' ? true : false,
                    fields: JSON.stringify(this.form.fields),
                },
                this.postSaveProcessing,
                this.handleError
            )
        },

        postSaveProcessing(response) {
            if (this.isJustCreated()) {
                let id = parseInt(response.id)
                this.form.id = id

                this.$router.replace({ path: '/app/forms/' + id })
            }

            this.isSaving = false

            util.toast({
                icon: 'success',
                titleText: 'Form is Saved.',
            })
        },

        deleteField(index) {
            util.confirm('Delete Field?', 'Are you sure to delete this field?', () => {
                this.form.fields.splice(index, 1)

                util.toast({ icon: 'success', title: 'Field deleted' })
            })
        },

        addField() {
            this.form.fields.push({
                name: 'Add New Field',
                type: null,
                desc: null,
                placeholder: null,
                validation: null,
                default: null,
                options: [],
            })
        },

        deleteForm() {
            util.confirm('Delete this form?', 'This action can not be reverted', () => {
                util.ajax('delete', '/api/forms/' + this.form.id, {}, () => {
                    util.notifySuccess('Deleted', 'The form has been successfully deleted')
                    this.$router.push('/app/forms')
                })
            })
        },
    },
}
</script>
