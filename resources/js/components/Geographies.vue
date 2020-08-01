<template>
    <div>
        <div class="text-sm uppercase text-gray-500 my-4">Most Popular</div>
        <div class="bg-white rounded text-xs text-gray-700 h-64 overflow-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="border-b bg-gray-100">
                        <th class="px-3 py-1 text-left">Pages</th>
                        <th class="px-3 py-1 text-left">Views</th>
                        <th class="px-3 py-1 text-left">Visitors</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b" v-for="page in pages">
                        <td class="px-3 py-1">
                            <a :href="page.id"
                                >Page representational state transfer for the virtue of richard
                                wilkins and other idiots</a
                            >
                        </td>
                        <td class="px-3 py-1">{{ page.total_views }}</td>
                        <td class="px-3 py-1">{{ page.unique_vistors }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pages: [],
        }
    },
    created() {
        util.ajax('get', '/api/dashboard/content', {}, (response) => {
            this.pages = response
        })
    },
}
</script>
