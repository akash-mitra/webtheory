<template>
    <div>
        <div class="cursor-pointer text-blue-500 underline" @click="itemBrowserVisible=true">
            {{ contentTitle || 'change' }}
        </div>
        <t-modal :show="itemBrowserVisible" @close="itemBrowserVisible=false" :show-footer="false">
            <template v-slot:header>
                <div class="w-full px-6 py-4 text-2xl border-b1">Search {{contentType}}</div>
            </template>

            <div class="px-6 py-4">
                <div class="w-full flex justify-between">
                    <input type="text" v-model="searchKey" placeholder="Enter your search phrase..." class="mr-4 w-full p-2 bg-gray-100 rounded border"/>
                    <button class="py-2 px-6 bg-blue-500 text-white rounded" @click="fireAjax">Search</button>
                </div>

                <div v-show="list.length > 0">
                    <div class="mt-4 border rounded">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="item in list" class="p-2 border-b bg-white hover:bg-blue-400 hover:text-white cursor-pointer" @click="selected(item)">
                                    <td class="px-6 py-2 whitespace-nowrap">{{ contentType }}</td>
                                    <td class="px-6 py-2 whitespace-nowrap">{{ item.id }}</td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <div v-if="contentType === 'pages'">
                                            {{ item.title }}
                                        </div>
                                        <div v-if="contentType === 'categories'">
                                            {{ item.name }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-xs text-gray-600 uppercase mt-4 pb-2">Showing {{ list.length }} results</div>
                </div>

            </div>

        </t-modal>
    </div>
</template>
<script>
export default {
    props: {
        contentType: {
            type: String
        },
        contentTitle: {
            type: String
        },
        contentId: {
            type: Number
        }
    },
    data() {
        return {
            itemBrowserVisible: false,
            isLoading: false,
            list: [],
            searchKey: '',
        }
    },
    methods: {
        fireAjax() {
            this.isLoading = true
            util.ajax('get', '/api/' + this.contentType + '?query=' + this.searchKey, {}, (response) => {
                if (this.contentType === 'pages') {
                    this.list = response.data
                }
                if (this.contentType === 'categories') {
                    this.list = response
                }
                this.isLoading = false
            })
        },

        selected(item) {
            this.$emit("select", item)
            this.itemBrowserVisible = false
        }
    },

    watch: {
        itemBrowserVisible(isModalVisible) {
            if (isModalVisible) this.fireAjax()
            else this.list = []
        }
    }
}
</script>
