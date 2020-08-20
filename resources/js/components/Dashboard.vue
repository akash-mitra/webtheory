<template>
    <div class="w-full px-10 py-4">
        <div>
            <div class="text-sm uppercase text-gray-500 px-2 my-4">metrics</div>

            <div class="w-full xl:flex">
                <div class="flex w-full xl:w-1/3 flex-wrap">
                    <BoardTileVisitors></BoardTileVisitors>
                    <BoardTileViews></BoardTileViews>
                    <BoardTilePages></BoardTilePages>
                    <BoardTileUsers></BoardTileUsers>
                </div>
                <div class="flex w-full xl:w-2/3 px-2 py-3">
                    <BoardTilePageViews></BoardTilePageViews>
                </div>
            </div>

            <div class="md:flex w-full flex-no-wrap">
                <div class="w-full lg:w-1/3 py-2 px-4">
                    <PopularPages></PopularPages>
                </div>

                <div class="w-full lg:w-1/3 p-2">
                    <BrowserDistributions></BrowserDistributions>
                </div>

                <div class="w-full lg:w-1/3 p-2">
                    <TrafficSources></TrafficSources>
                </div>
            </div>

            <div class="md:flex w-full flex-no-wrap">
                <div class="w-full lg:w-2/3 p-2">
                    <div class="text-sm uppercase text-gray-500 my-4">
                        Recent Comments
                    </div>
                    <div class="overflow-auto p-2" style="max-height: 30rem;">
                        <BoardComments></BoardComments>
                    </div>
                </div>

                <div class="w-full lg:w-1/3 p-2">
                    <div class="text-sm uppercase text-gray-500 my-4">New Members</div>
                    <div class="overflow-auto p-2" style="max-height: 30rem;">
                        <BoardUsers></BoardUsers>
                    </div>
                    <router-link
                        :to="{ name: 'users.index' }"
                        class="block text-right text-blue-400 my-2 text-sm"
                    >
                        See All
                    </router-link>
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
import PopularPages from './PopularPages.vue'
import BrowserDistributions from './BrowserDistributions.vue'
import TrafficSources from './TrafficSources.vue'
export default {
    components: {
        BoardTilePages,
        BoardTileUsers,
        BoardTileVisitors,
        BoardTileViews,
        BoardTilePageViews,
        BoardComments,
        BoardUsers,
        PopularPages,
        BrowserDistributions,
        TrafficSources,
    },
}
</script>
