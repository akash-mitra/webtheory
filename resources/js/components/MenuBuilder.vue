<template>
    <div class="w-full overflow-x-scroll">
        <table class="min-w-full divide-y divide-gray-200 shadow-md rounded">
            <thead class="bg-gray-100 border">
                <tr>
                    <th
                        scope="col"
                        class="relative px-6 py-3"
                    >
                        <span class="sr-only">Move</span>
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider"
                    >
                        Name
                    </th>

                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider"
                    >
                        Type
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider"
                    >
                        Item
                    </th>
                    <th
                        scope="col"
                        class="py-3 text-left text-xs text-gray-600 uppercase tracking-wider"
                    >
                        Home
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Delete</span>
                    </th>
                </tr>
            </thead>
            <draggable :list="menus" tag="tbody" class="divide-y divide-gray-200 bg-white" handle=".handle" :dragover-bubble="true" chosen-class="chosen" drag-class="drag">
                <tr v-for="menu in menus" :key="menu.id">
                    <td class="pl-4 py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 handle cursor-move" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="21" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="3" y2="18"></line></svg>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <input
                            type="text"
                            v-model="menu.title"
                            class="bg-gray-100 border p-1 rounded outline-none self-start"
                        />
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <select
                            v-model="menu.menuable_type"
                            class="bg-gray-100 border p-1 rounded outline-none"
                        >
                            <option v-for="option in options" v-bind:value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <content-browser
                            @select="changeMenuableItem(menu, $event)"
                            :content-id="menu.menuable_id"
                            :content-type="modelLabelMap(menu.menuable_type)"
                            :content-title="modelLabelMap(menu.menuable_type) === 'pages' ? menu.menuable.title : menu.menuable.name"
                        ></content-browser>
                    </td>

                    <td class=" py-4 whitespace-nowrap">
                        <input
                            type="checkbox"
                            v-model="menu.home"
                            :true-value="true"
                            :false-value="false"
                            :disabled="!menu.home && isHomeSet"
                        />
                    </td>

                    <td class="px-6 py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-3 h-4 w-4 text-gray-400 hover:text-red-400 cursor-pointer" @click="remove(menu)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </td>
                </tr>
                </draggable>
        </table>

        <div class="flex justify-between mt-6">
            <div class="inline-flex shadow-md px-6 py-2 bg-white text-blue-500 rounded cursor-pointer" @click="add">Add New</div>
            <div class="inline-flex shadow-md px-6 py-2 bg-blue-500 text-white rounded cursor-pointer" @click="save">Save All</div>
        </div>

    </div>
</template>
<script>
import ContentBrowser from './ContentBrowser'
import draggable from 'vuedraggable'

export default {
    components: { ContentBrowser, draggable },
    data() {
        return {
            menus: [],
            isSaving: false,
            isLoading: true,
            options: [
                { text: 'Category', value: 'App\\Category' },
                { text: 'Page', value: 'App\\Page' },
            ],
        }
    },
    created() {
        this.isLoading = true
        util.ajax('get', '/api/menus', {}, (response) => {
            this.menus = response
            this.isLoading = false
        })
    },

    methods: {

        /**
         * Adds a new menu item in menus.
         */
        add() {
           let max_sequence = Math.max.apply(null, this.menus.map(item => item.sequence_num))
           this.menus.push({
               id: -1 * Math.random(),
               title: "",
               menuable_id: 0,
               menuable: { title: null },
               menuable_type: 'App\\Page',
               sequence_num: max_sequence + 1,
               home: false
           })
        },

        /**
         * Save all the menu items individually by looping through "menus".
         */
        save() {
            this.menus.forEach((menu, index) => {
                // Recalculate the sequence number based on the positions of the menu item while saving.
                menu.sequence_num = index + 1

                if (menu.hasOwnProperty('id') && menu.id > 0) {
                    // update
                    util.ajax('put', '/api/menus/' + menu.id, menu, (response) => {
                        console.log(response)
                    })
                } else {
                    // create
                    util.ajax('post', '/api/menus', menu, (response) => {
                        console.log(response)
                    })
                }
            })

        },

        /**
         * Remove a given menu item from the database.
         */
        remove(menu) {
            let p = this
            util.confirm('Delete "' + menu.title + '"?', 'This action can not be undone.', function () {
                util.ajax('delete', '/api/menus/' + menu.id, {}, (response) => {
                    for (let i = 0; i < p.menus.length; i++) {
                        if (p.menus[i].id === menu.id) {
                            p.menus.splice(i, 1)
                        }
                    }
                    util.notifySuccess('Deleted', 'The menu has been successfully deleted')
                })
            })
        },

        /**
         * Change the menuable of a given menu item based on information received through event.
         * @param menu
         * @param event
         */
        changeMenuableItem(menu, event) {

            menu.menuable_id = event.id

            if (this.modelLabelMap(menu.menuable_type) === 'pages') {
                menu.menuable.title = event.title
            }

            if (this.modelLabelMap(menu.menuable_type) === 'categories') {
                menu.menuable.name = event.name
            }

        },

        /**
         * Map the laravel menuable name (e.g. App\Page) against a more readable label (e.g. pages).
         * @param model
         * @returns {*}
         */
        modelLabelMap(model) {
            let map = {
                "App\\Page": "pages",
                "App\\Category": "categories"
            }
            return map[model]
        },
    },

    computed: {
        /**
         * Checks if any menu item has home flag set
         * @returns {boolean}
         */
        isHomeSet() {
            return this.menus.filter(item => item.home === true).length > 0
        }
    }
}
</script>

<style scoped>
.chosen {
    background-color: floralwhite;
}
.drag {
    background-color: white;
}
</style>
