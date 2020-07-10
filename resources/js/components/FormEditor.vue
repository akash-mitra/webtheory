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
            <a href="#" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow"
                >Save Form</a
            >
        </div>
        <div class="px-6">
            {{ form.description }}
        </div>

        <div class="px-6 w-full flex justify-start items-center my-8 border-b">
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

        <div v-if="tab === 'general'" class="px-6">
            <label class="block pb-2 text-gray-600">Form Name</label>
            <input v-model="form.name" class="w-full max-w-lg border px-4 py-2" />
            <label class="block pb-2 text-gray-600 mt-3">Description</label>
            <textarea
                v-model="form.description"
                class="w-full max-w-lg border px-4 py-2"
            ></textarea>
        </div>

        <div v-if="tab === 'responses'" class="px-6">
            <div class="flex flex-col">
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div
                        class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200"
                    >
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th
                                        v-for="f in form.fields"
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider"
                                    >
                                        {{ f.name }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-sm">
                                <tr v-for="(r, i) in responses">
                                    <td
                                        v-for="(f, i) in form.fields"
                                        class="px-6 py-4 whitespace-no-wrap border-b border-gray-200"
                                    >
                                        {{ r[i] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormEditorField from './FormEditorField.vue'

export default {
    data() {
        return {
            form: null,
            responses: null,
            tab: 'general',
        }
    },

    components: {
        FormEditorField,
    },

    created() {
        this.form = {
            id: 2,
            name: 'Magician Enrollment Form',
            description: 'Enroll your favorite magician with all the trivia',
            status: 'Live',
            created_ago: '2 days ago',
            fields: [
                {
                    name: 'name',
                    type: 'text',
                    desc: 'Provide your name',
                    placeholder: 'Harry Potter',
                    validation: 'min:2|max:100',
                    default: '',
                    options: [],
                },
                {
                    name: 'email',
                    type: 'email',
                    desc: 'Provide a valid email id.',
                    placeholder: 'harry.potter@example.com',
                    validation: 'email',
                    default: '',
                    options: [],
                },
                {
                    name: 'address',
                    type: 'textbox',
                    desc: 'Contact Address',
                    placeholder: '4 Privet Drive, Surrey, UK',
                    validation: '',
                    default: '',
                    options: [],
                },
                {
                    name: 'magic_house',
                    type: 'radio',
                    desc: 'Which Hogwarts House do you belong?',
                    placeholder: 'Gryffindor',
                    validation: '',
                    default: 'Gryffindor',
                    options: ['Hufflepuff', 'Ravenclaw', 'Gryffindor', 'Slytherin'],
                },
                {
                    name: 'mentor',
                    type: 'select',
                    desc: 'Best defence against the dark art teacher',
                    placeholder: 'Dumbledor',
                    validation: '',
                    default: '',
                    options: ['Dumbledor', 'Severus Snape', 'Remus Lupin', 'Mad-eye Moody'],
                },
                {
                    name: 'friends',
                    type: 'multiselect',
                    desc: '',
                    placeholder: 'Friends versus enemies',
                    validation: '',
                    default: '',
                    options: ['Ron Weasley', 'Hermione', 'Neville Longbottom', 'Lucious Malfoy'],
                },
            ],
        }

        this.responses = [
            [
                'Harry Potter',
                'harry.potter@gmail.com',
                '4 Privet Dr, Surrey, UK',
                'Gryffindor',
                'Dumbledor',
                ['Ron Weasley', 'Hermione', 'Neville Longbottom'],
            ],
            [
                'Harmione Gringer',
                'harmony@gmail.com',
                'Richter, UK',
                'Gryffindor',
                'Remus Lupin',
                ['Harry'],
            ],
        ]
    },

    methods: {
        deleteField(index) {
            util.confirm('Delete Field?', 'Are you sure to delete this field?', () => {
                this.form.fields.splice(index, 1)

                util.toast({ icon: 'success', title: 'Field deleted' })
            })
        },

        addField() {
            this.form.fields.push({
                name: 'New Field',
                type: null,
                desc: null,
                placeholder: null,
                validation: null,
                default: null,
                options: [],
            })
        },
    },
}
</script>
