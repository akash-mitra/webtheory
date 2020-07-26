<template>
    <BoardTile
        tile-class="bg-blue-500"
        text-class="text-blue-100"
        cta-class="text-blue-200"
        :loading="isLoading"
    >
        <template v-slot:metric>{{ metric }}</template>
        <template v-slot:header>{{ header }}</template>
        <template v-slot:text>
            <a href="/app/pages/create">{{ text }}</a>
        </template>
    </BoardTile>
</template>

<script>
import BoardTile from './BoardTile.vue'
export default {
    data() {
        return {
            metric: null,
            header: 'Pages',
            text: 'Create New',
            isLoading: true,
        }
    },
    components: { BoardTile },
    created() {
        util.ajax('get', '/api/dashboard/pages-count', {}, (response) => {
            this.metric = response
            this.isLoading = false
        })
    },
}
</script>
