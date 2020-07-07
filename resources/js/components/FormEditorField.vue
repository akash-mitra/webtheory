<template>
    <div>
        <div
            class="w-full bg-indigo-600 text-indigo-100 p-4 mb-4 flex justify-between items-center"
        >
            <div class="text-lg uppercase">{{ field.name }}</div>
            <div class="text-lg cursor-pointer" @click="$emit('delete')">
                <svg
                    class="h-6 w-6 mx-auto block text-indigo-100 hover:text-white"
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
            </div>
        </div>

        <div class="w-full sm:flex py-2 items-start px-6">
            <div
                class="w-full sm:w-1/4 py-2 font-bold sm:text-right pr-6 uppercase text-gray-600 text-sm"
            >
                Field Name
            </div>
            <div class="w-full sm:w-3/4">
                <input
                    type="text"
                    v-model="field.name"
                    placeholder="Name of this field in your form"
                    class="bg-gray-100 px-4 py-2 border rounded w-full"
                />
            </div>
        </div>

        <div class="w-full sm:flex py-2 items-start px-6">
            <div
                class="w-full sm:w-1/4 py-2 font-bold sm:text-right pr-6 uppercase text-gray-600 text-sm"
            >
                Type
            </div>
            <div class="w-full sm:w-3/4">
                <select class="bg-gray-100 px-4 py-2 border rounded w-full" v-model="field.type">
                    <option :value="type" :key="type" v-for="type in types">
                        {{ type }}
                    </option>
                </select>
            </div>
        </div>

        <div class="w-full sm:flex py-2 items-start px-6">
            <div
                class="w-full sm:w-1/4 py-2 font-bold sm:text-right pr-6 uppercase text-gray-600 text-sm"
            >
                Description
            </div>
            <div class="w-full sm:w-3/4">
                <textarea
                    class="bg-gray-100 px-4 py-2 border rounded w-full"
                    v-model="field.desc"
                    placeholder="Description of this field"
                ></textarea>
            </div>
        </div>

        <div class="w-full sm:flex py-2 items-start px-6">
            <div
                class="w-full sm:w-1/4 py-2 font-bold sm:text-right pr-6 uppercase text-gray-600 text-sm"
            >
                Placeholder Text
            </div>
            <div class="w-full sm:w-3/4">
                <input
                    type="text"
                    v-model="field.placeholder"
                    placeholder="Placeholder text to be shown for this field"
                    class="bg-gray-100 px-4 py-2 border rounded w-full"
                />
            </div>
        </div>

        <div class="w-full sm:flex py-2 items-start px-6">
            <div
                class="w-full sm:w-1/4 py-2 font-bold sm:text-right pr-6 uppercase text-gray-600 text-sm"
            >
                Validation Rule
            </div>
            <div class="w-full sm:w-3/4">
                <input
                    type="text"
                    v-model="field.validation"
                    placeholder="e.g., min:10|max:100"
                    class="bg-gray-100 px-4 py-2 border rounded w-full"
                />
            </div>
        </div>

        <div
            class="w-full sm:flex py-2 items-start px-6"
            v-if="['select', 'multiselect', 'radio'].indexOf(field.type) > -1"
        >
            <div
                class="w-full sm:w-1/4 py-2 font-bold sm:text-right pr-6 uppercase text-gray-600 text-sm"
            >
                Options
            </div>
            <div class="w-full sm:w-3/4">
                <div
                    class="w-full flex items-center justify-start"
                    v-for="(option, index) in field.options"
                    :class="index != 0 ? 'border-t' : ''"
                >
                    <div class="flex-grow mr-3 px-4 py-2">
                        {{ option }}
                    </div>
                    <button class="px-4 py-1 text-sm" @click="field.options.splice(index, 1)">
                        Delete
                    </button>
                </div>
                <div class="flex mt-2">
                    <input
                        type="text"
                        class="flex-grow mr-3 bg-gray-100 px-4 py-2 border rounded w-full"
                        placeholder="Add a new option"
                        v-model="field.new_option"
                    />
                    <button
                        class="px-4 py-1 text-sm"
                        @click="
                            field.options.push(field.new_option)
                            field.new_option = null
                        "
                    >
                        Add
                    </button>
                </div>
            </div>
        </div>

        <div class="w-full sm:flex py-2 items-start px-6">
            <div
                class="w-full sm:w-1/4 py-2 font-bold sm:text-right pr-6 uppercase text-gray-600 text-sm"
            >
                Default Value
            </div>
            <div class="w-full sm:w-3/4">
                <input
                    v-if="['select', 'multiselect', 'radio'].indexOf(field.type) === -1"
                    type="text"
                    v-model="field.default"
                    placeholder="A value to pre-fill the field in the form"
                    class="bg-gray-100 px-4 py-2 border rounded w-full"
                />

                <select
                    v-else
                    class="bg-gray-100 px-4 py-2 border rounded w-full"
                    v-model="field.default"
                >
                    <option disabled value="">
                        Select a default value
                    </option>
                    <option :value="option" v-for="option in field.options">
                        {{ option }}
                    </option>
                </select>
            </div>
        </div>

        <div class="py-4"></div>
    </div>
</template>

<script>
export default {
    props: {
        field: {
            type: Object,
        },
    },

    data() {
        return {
            types: ['text', 'email', 'textbox', 'radio', 'select', 'multiselect'],
            timeout: null,
        }
    },
}
</script>
