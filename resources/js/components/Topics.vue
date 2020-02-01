<template>

    <div class="max-w-4xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">Topics <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{ topics.length }}</span></h2>

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

                <hierarchy-node
                    :item="topic"
                    :needle="searchPhrase"
                    v-for="topic in filtered"
                    :key="topic.id">
                </hierarchy-node>

        </div>

    </div>
</template>

<script>



    export default {

        data() {
            return {
                topics: [],
                selected: null,
                tab: 'all',
                searchPhrase: ''
            }
        },

        created() {
            util.ajax ('get', '/api/categories', {},  (response) => {
                this.topics = response
                console.log(this.unflatten(this.topics))
            })
        },


        computed: {

            filtered() {
                return this.topics.filter(topic => {

                    if (topic.parent_id != null) return false


                    return true
                })
            }
        },
        methods: {

            unflatten(arr) {
                var tree = [],
                    mappedArr = {},
                    arrElem,
                    mappedElem;

                // First map the nodes of the array to an object -> create a hash table.
                for(var i = 0, len = arr.length; i < len; i++) {
                    arrElem = arr[i];
                    mappedArr[arrElem.id] = arrElem;
                    mappedArr[arrElem.id]['children'] = [];
                }


                for (var id in mappedArr) {
                    if (mappedArr.hasOwnProperty(id)) {
                        mappedElem = mappedArr[id];
                        // If the element is not at the root level, add it to its parent array of children.
                        if (mappedElem.parent_id) {
                            mappedArr[mappedElem['parent_id']]['children'].push(mappedElem);
                        }
                        // If the element is at the root level, add it to first level elements array.
                        else {
                            tree.push(mappedElem);
                        }
                    }
                }
                return tree;
            },


        }

    };

</script>

<style scoped>
    p { color: red;}
</style>