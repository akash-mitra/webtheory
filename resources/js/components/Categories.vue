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
                    <path
                        d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"
                    ></path>
                </svg>
                Categories
                <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{
                    categories.length
                }}</span>
            </h2>

            <a
                href="/app/categories/create"
                class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow"
                >Create</a
            >
        </div>

        <div class="px-6">
            <input
                type="text"
                class="w-full rounded-lg shadow px-4 py-3 text-sm focus:outline-none"
                name="search"
                placeholder="Search by category name..."
                v-model="searchPhrase"
            />
        </div>

        <div class="p-6">
            <Category
                :item="category"
                :needle="searchPhrase"
                v-for="category in categories"
                :key="category.id"
            >
            </Category>
        </div>
    </div>
</template>

<script>
import Category from './Category.vue'

export default {
    data() {
        return {
            categories: [],
            selected: null,
            tab: 'all',
            searchPhrase: '',
        }
    },

    components: { Category },

    created() {
        util.ajax('get', '/api/categories', {}, (response) => {
            this.categories = this.toTree(response)
        })
    },

    methods: {
        toTree(arr) {
            var tree = [],
                hashTable = {},
                arrayItem,
                hashTableItem

            // First map the nodes of the array to an object -> create a hash table.
            for (var i = 0, len = arr.length; i < len; i++) {
                arrayItem = arr[i]
                hashTable[arrayItem.id] = arrayItem
                hashTable[arrayItem.id]['children'] = []
            }

            for (var id in hashTable) {
                if (hashTable.hasOwnProperty(id)) {
                    hashTableItem = hashTable[id]
                    // If the element is not at the root level, add it to its parent array of children.
                    if (hashTableItem.parent_id) {
                        hashTable[hashTableItem['parent_id']]['children'].push(hashTableItem)
                    }
                    // If the element is at the root level, add it to first level elements array.
                    else {
                        tree.push(hashTableItem)
                    }
                }
            }
            return tree
        },
    },
}
</script>
