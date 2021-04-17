<template>
    <BoardTile tile-class="bg-indigo-500" text-class="text-indigo-100" cta-class="text-indigo-200">
        <template v-slot:metric>{{ metric }}</template>
        <template v-slot:header>Visitors</template>
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
        }
    },

    created() {
        util.ajax('get', '/api/dashboard/unique/monthly', {}, (response) => {
            this.metric = response[0].unique_visitors
            this.text = util.getMonthName(response[0].month_key.toString())
            this.isLoading = false
        })
    },
}
</script>
