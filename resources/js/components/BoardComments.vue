<template>
    <div class="flex flex-wrap relative">
        <div v-if="isLoading" v-for="i in Array(4).keys()">
            <CommentStripDummy></CommentStripDummy>
        </div>

        <div
            v-if="noData"
            class="absolute top-0 left-0 w-full h-64 p-6 flex items-center justify-center"
        >
            There is no comment available to show here
        </div>

        <div class="pr-3 mb-3 w-full xl:max-w-sm" v-for="(c, index) in paginatedComments">
            <CommentStrip
                :comment="c"
                :key="c.id"
                v-if="index < 10"
                class="bg-white border rounded-lg shadow"
            ></CommentStrip>
        </div>
    </div>
</template>

<script>
import CommentStrip from './CommentStrip.vue'
import CommentStripDummy from './CommentStripDummy.vue'

export default {
    data() {
        return {
            paginatedComments: [],
            isLoading: true,
            noData: false,
        }
    },
    components: {
        CommentStripDummy,
        CommentStrip,
    },
    created() {
        let url = '/api/dashboard/top-comments'

        this.isLoading = true

        util.ajax('get', url, {}, (response) => {
            // response = []

            if (response.length < 1) {
                this.noData = true
            } else {
                this.paginatedComments = response
                this.isLoading = false
            }
        })
    },
}
</script>
