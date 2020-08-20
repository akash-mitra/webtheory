<template>
    <BoardTile tile-class="bg-blue-500" text-class="text-blue-100" cta-class="text-blue-200">
        <template v-slot:metric>{{ metric }}</template>
        <template v-slot:header>Views</template>
        <template v-slot:text>{{ text }}</template>
    </BoardTile>
</template>

<script>
import BoardTile from './BoardTile.vue'
export default {
    components: { BoardTile },
    data() {
        return {
            metric: '...',
            text: 'Calculating...',

            isLoading: true,
        }
    },

    created() {
        util.ajax('get', '/api/dashboard/views/monthly', {}, (response) => {
            this.metric = response[0].total_views
            this.text = util.getMonthName(response[0].month_key)
            this.isLoading = false
        })
    },
}
</script>
