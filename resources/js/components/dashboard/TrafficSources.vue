<template>
    <div>
        <div class="text-sm uppercase text-gray-500 my-4">Top Traffic Sources</div>
        <div class="bg-white rounded text-xs text-gray-700 h-64 overflow-auto">
            <div v-if="noData" class="w-full flex justify-center items-center relative">
                <SVGCreateContent class="max-h-full"></SVGCreateContent>
                <div class="absolute bottom-0 mb-12 left-0 px-6">
                    Not sufficient traffic source data yet.
                </div>
            </div>
            <table v-else class="table-auto w-full">
                <thead>
                    <tr class="border-b bg-gray-100">
                        <th class="px-3 py-1 text-left">From</th>
                        <th class="px-3 py-1 text-left">Referred</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="border-b"
                        v-for="item in referrers"
                        v-if="item.referrer != null && item.referrer.length > 0"
                    >
                        <td class="px-3 py-1">
                            {{ item.referrer }}
                        </td>
                        <td class="px-3 py-1">{{ item.total_views }}</td>
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
            referrers: [],
            noData: false,
        }
    },
    created() {
        util.ajax('get', '/api/dashboard/referrer', {}, (response) => {

            if (response.length < 1) {
                this.noData = true
            } else {
                this.referrers = response
            }
        })
    },
}
</script>
