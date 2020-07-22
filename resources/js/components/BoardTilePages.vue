<template>
    <BoardTile tile-color="blue">
        <template v-slot:metric>
            {{ metric }}
        </template>
        <template v-slot:header>
            {{ header }}
        </template>
        <template v-slot:text>
            <a href="/app/pages/create" class="text-blue-200">{{ text }}</a>
        </template>
    </BoardTile>
</template>

<script>
import BoardTile from './BoardTile.vue'
export default {
    data() {
        return {
            metric: '103',
            header: 'Pages',
            text: 'Create New',
        }
    },
    components: { BoardTile },
}
</script>
