<template>
    <div>
        <div class="text-sm uppercase text-gray-500 my-4">Most Popular Pages</div>
        <div class="bg-white rounded text-xs text-gray-700 h-64 overflow-auto">
            <div v-if="noData" class="w-full flex justify-center items-center relative">
                <SVGCreateContent class="max-h-full"></SVGCreateContent>
                <div class="absolute bottom-0 mb-12 left-0 px-6">
                    Not sufficient page data yet.
                </div>
            </div>
            <table v-else class="table-auto w-full">
                <thead>
                    <tr class="border-b bg-gray-100">
                        <th class="px-3 py-1 text-left">#</th>
                        <th class="px-3 py-1 text-left">Pages</th>
                        <th class="px-3 py-1 text-left">Views</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b" v-for="(page, index) in pages">
                        <td class="px-3 py-1">{{ index + 1 }}</td>
                        <td class="px-3 py-1">
                            <a :href="'/app/pages/' + page.content_id" class="text-blue-600">{{
                                page.title
                            }}</a>
                        </td>
                        <td class="px-3 py-1">{{ page.total_views }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    components: {
        SVGCreateContent: () => import('../svg/SVGCreateContent.vue'),
    },
    data() {
        return {
            pages: [],
            noData: false,
        }
    },
    created() {
        util.ajax('get', '/api/dashboard/content', {}, (response) => {
            // response = []
            if (response.length < 1) {
                this.noData = true
            } else {
                this.pages = response
            }
        })
    },
}
</script>
