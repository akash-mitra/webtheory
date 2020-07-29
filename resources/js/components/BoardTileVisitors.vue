<template>
    <BoardTile tile-class="bg-indigo-500" text-class="text-indigo-100" cta-class="text-indigo-200">
        <template v-slot:metric>{{ metric }}</template>
        <template v-slot:header>{{ header }}</template>
        <template v-slot:text>{{ text }}</template>
    </BoardTile>
</template>

<script>
import BoardTile from './BoardTile.vue'
export default {
    props: ['metric'],
    data() {
        return {
            header: 'Visitors',
            text: 'July',
        }
    },
    components: { BoardTile },
}
</script>
