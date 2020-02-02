<template>

    <div class="max-w-4xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">
                Topics
                <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{ topics.length }}</span>
            </h2>

            <a href="/app/topics/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">Create</a>

        </div>

        <div class="px-6">
            <input type="text"
                class="w-full rounded-lg shadow px-4 py-3 text-sm focus:outline-none"
                name="search"
                placeholder="Search by topic name..."
                v-model="searchPhrase"
            />
        </div>

        <div class="p-6">

            <Topic
                    :item="topic"
                    :needle="searchPhrase"
                    v-for="topic in topics"
                    :key="topic.id">
            </Topic>

        </div>

    </div>
</template>

<script>

    import Topic from './Topic.vue';

    export default {

        data() {
            return {
                topics: [],
                selected: null,
                tab: 'all',
                searchPhrase: ''
            }
        },

        components: { Topic },

        created() {
            util.ajax ('get', '/api/categories', {},  (response) => { this.topics = this.toTree(response) })
        },


        methods: {

            toTree(arr) {

                var tree = [],
                    hashTable = {},
                    arrayItem,
                    hashTableItem;

                // First map the nodes of the array to an object -> create a hash table.
                for(var i = 0, len = arr.length; i < len; i++) {
                    arrayItem = arr[i];
                    hashTable[arrayItem.id] = arrayItem;
                    hashTable[arrayItem.id]['children'] = [];
                }


                for (var id in hashTable) {
                    if (hashTable.hasOwnProperty(id)) {
                        hashTableItem = hashTable[id];
                        // If the element is not at the root level, add it to its parent array of children.
                        if (hashTableItem.parent_id) {
                            hashTable[hashTableItem['parent_id']]['children'].push(hashTableItem);
                        }
                        // If the element is at the root level, add it to first level elements array.
                        else {
                            tree.push(hashTableItem);
                        }
                    }
                }
                return tree;
            },
        }
    };

</script>