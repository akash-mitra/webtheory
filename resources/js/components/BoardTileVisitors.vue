<template>
    <BoardTile tile-color="indigo">
        <template v-slot:metric>{{ metric }}</template>
        <template v-slot:header>{{ header }}</template>
        <template v-slot:text>{{ text }}</template>
    </BoardTile>
</template>

<script>
import BoardTile from './BoardTile.vue'
export default {
    data() {
        return {
            metric: '15K',
            header: 'Visitors',
            text: 'July',
        }
    },
    components: { BoardTile },
}
</script>
