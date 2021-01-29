<template>
    <div class="w-full overflow-x-scroll">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 border">
                <tr>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Name
                    </th>

                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Type
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Item
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Sequence
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="menu in menus">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input
                            type="text"
                            v-model="menu.title"
                            class="bg-gray-100 border p-1 rounded outline-none"
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
                            @select="changeItem(menu, $event)"
                            :content-id="menu.menuable_id"
                            :content-type="modelLabelMap(menu.menuable_type)"
                            :content-title="modelLabelMap(menu.menuable_type) === 'pages' ? menu.menuable.title : menu.menuable.name"
                        ></content-browser>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ menu.sequence_num }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Edit
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="inline-block mt-4 px-6 py-2 bg-blue-500 text-white rounded shadow cursor-pointer" @click="save">Save All</div>
    </div>
</template>
<script>
import ContentBrowser from './ContentBrowser'

export default {
    components: { ContentBrowser },
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
        changeItem(menu, event) {

            menu.menuable_id = event.id

            if (this.modelLabelMap(menu.menuable_type) === 'pages') {
                menu.menuable.title = event.title
            }

            if (this.modelLabelMap(menu.menuable_type) === 'categories') {
                menu.menuable.name = event.name
            }

        },

        save() {
            this.menus.forEach((menu) => {
                if (menu.hasOwnProperty('id') && menu.id > 0) {
                    util.ajax('put', '/api/menus/' + menu.id, menu, (response) => {
                        console.log(response)
                    })
                } else {
                    util.ajax('post', '/api/menus', menu, (response) => {
                        console.log(response)
                    })
                }
            })

        },

        modelLabelMap(model) {

            let map = {
                "App\\Page": "pages",
                "App\\Category": "categories"
            }
            return map[model]
        }
    }
}
</script>
