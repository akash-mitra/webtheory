<template>
    <div class="flex flex-wrap">
        <div
            v-if="isLoading"
            v-for="i in Array(4).keys()"
            class="flex flex-col justify-between flex-grow-0 max-w-full md:max-w-sm bg-white border rounded m-2 shadow"
        >
            <div class="text-sm text-gray-800 p-4">
                <span class="text-gray-300 bg-gray-300"
                    >Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae deleniti ut
                    commodi neque impedit minima iusto, quia eos, iste repellendus natus eaque,
                    aperiam accusantium voluptatem!</span
                >
            </div>

            <div class="h-12 flex items-center p-4 bg-gray-100 justify-between border-t"></div>
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

export default {
    data() {
        return {
            paginatedComments: [],
            isLoading: true,
        }
    },
    components: { CommentStrip },
    created() {
        let url = '/api/dashboard/top-comments'

        this.isLoading = true

        util.ajax('get', url, {}, (response) => {
            this.paginatedComments = response

            this.isLoading = false
        })
    },
}
</script>
