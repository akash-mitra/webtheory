<template>
    <div class="max-w-4xl mx-auto">
        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-indigo-600 text-2xl flex items-center">
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
                Forms
                <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{
                    forms.length
                }}</span>
            </h2>

            <a
                href="/app/forms/create"
                class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow"
                >Create</a
            >
        </div>

        <div class="px-6">
            <input
                type="text"
                class="w-full rounded-lg shadow px-4 py-3 text-sm focus:outline-none"
                name="search"
                placeholder="Search by form name..."
                v-model="searchPhrase"
            />
        </div>

        <div class="p-6">
            <div
                class="w-full md:flex items-center justify-between py-2 text-sm uppercase border-b text-gray-600 hidden"
            >
                <div class="w-full md:w-1/3 px-4">Form</div>
                <div class="w-full md:w-1/3 px-4">Status</div>
                <div class="w-full md:w-1/3 px-4">Actions</div>
            </div>
            <Form
                :item="form"
                :needle="searchPhrase"
                v-for="form in screened"
                :key="form.id"
                class="border-b p-4 text-sm"
            >
            </Form>
        </div>
    </div>
</template>

<script>
import Form from './Form.vue'

export default {
    data() {
        return {
            forms: [],
            selected: null,
            tab: 'all',
            searchPhrase: '',
        }
    },

    components: { Form },

    created() {
        util.ajax('get', '/api/forms', {}, (response) => (this.forms = response.data))
    },

    computed: {
        screened() {
            return this.forms.filter(
                (form) => form.name.toLowerCase().indexOf(this.searchPhrase.toLowerCase()) != -1
            )
        },
    },
}
</script>
