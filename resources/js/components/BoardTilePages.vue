<template>
    <BoardTile tile-class="bg-blue-500" text-class="text-blue-100" cta-class="text-blue-200">
        <template v-slot:metric>
            {{ metric }}
        </template>
        <template v-slot:header>
            {{ header }}
        </template>
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
            metric: '103',
            header: 'Pages',
            text: 'Create New',
        }
    },
    components: { BoardTile },
}
</script>
