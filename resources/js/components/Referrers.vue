<template>
    <div>
        <div class="text-sm uppercase text-gray-500 my-4">Top Referrers</div>
        <div class="bg-white rounded text-xs text-gray-700 h-64 overflow-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="border-b bg-gray-100">
                        <th class="px-3 py-1 text-left">From</th>
                        <th class="px-3 py-1 text-left">Referred</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="border-b"
                        v-for="referrer in referrers"
                        v-if="referrer.referrer_domain.length > 0"
                    >
                        <td class="px-3 py-1">
                            {{ referrer.referrer_domain }}
                        </td>
                        <td class="px-3 py-1">{{ referrer.total_views }}</td>
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
            referrers: [],
        }
    },
    created() {
        util.ajax('get', '/api/dashboard/referrer', {}, (response) => {
            this.referrers = response
        })
    },
}
</script>
