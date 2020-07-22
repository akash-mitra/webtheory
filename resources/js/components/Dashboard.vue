<template>
    <div class="w-full px-10 py-4">
        <div>
            <div class="text-sm uppercase text-gray-500 px-2 my-4">metrics</div>

            <div class="w-full xl:flex">
                <div class="flex w-full xl:w-1/3 flex-wrap">
                    <BoardTilePages></BoardTilePages>

                    <BoardTileUsers></BoardTileUsers>

                    <BoardTileVisitors></BoardTileVisitors>

                    <BoardTileViews></BoardTileViews>
                </div>
                <div class="flex w-full xl:w-2/3 px-2 py-3">
                    <BoardTilePageViews></BoardTilePageViews>
                </div>
            </div>

            <div class="md:flex w-full">
                <div class="w-full max-w-sm p-2">
                    <div class="text-sm uppercase text-gray-500 px-2 my-4">New Members</div>
                    <BoardUsers></BoardUsers>
                </div>
                <div class="w-full flex-grow p-2">
                    <div class="text-sm uppercase text-gray-500 px-2 my-4">Recent Comments</div>
                    <BoardComments></BoardComments>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BoardTilePages from './BoardTilePages.vue'
import BoardTileUsers from './BoardTileUsers.vue'
import BoardTileVisitors from './BoardTileVisitors.vue'
import BoardTileViews from './BoardTileViews.vue'
import BoardTilePageViews from './BoardTilePageViews.vue'
import BoardUsers from './BoardUsers.vue'
import BoardComments from './BoardComments.vue'
export default {
    data() {
        return {}
    },

    created() {},

    components: {
        BoardTilePages,
        BoardTileUsers,
        BoardTileVisitors,
        BoardTileViews,
        BoardTilePageViews,
        BoardComments,
        BoardUsers,
    },
}
</script>
