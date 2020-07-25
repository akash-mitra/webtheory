<template>
    <BoardTile tile-class="bg-green-500" text-class="text-green-100" cta-class="text-green-200">
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
            metric: '1290',
            header: 'Users',
            text: 'View Users',
        }
    },
    components: { BoardTile },
}
</script>
