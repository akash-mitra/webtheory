<template>
    <div>
        <div class="text-sm text-gray-600 pt-10 pb-3 uppercase">Organize</div>

        <div class="bg-white rounded w-full py-6 px-4 border-t-2 border-blue-400 shadow">
            <div class="w-full px-4">
                <div class="uppercase1 text-gray-800 text-sm">Category</div>
                <div class="py-3 flex items-center text-xs text-gray-600 overflow-y-scroll">
                    You may organize your pages under various categories. Category names can be used
                    to create menu items that can link all the pages under the same category.
                </div>

                <div class="inline-block relative w-64">
                    <select
                        id="category_value"
                        v-model="value"
                        @change="$emit('input', value)"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option
                            v-for="category in categories"
                            :value="category.key"
                            v-bind:key="category.key"
                        >
                            {{ category.value }}
                        </option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                    >
                        <svg
                            class="fill-current h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['value'],

    data() {
        return {
            categories: [],
        }
    },

    created: function () {
        util.ajax('get', '/api/lov/categories', {}, (data) => {
            this.categories = data
        })
    },
}
</script>
