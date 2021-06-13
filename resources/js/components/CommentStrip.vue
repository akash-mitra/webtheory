<template>
    <div class="flex flex-col justify-between">
        <div class="text-sm text-gray-800 px-4 my-4 truncate">
            <a :href='comment.page.url' class='font-bold text-blue-600'>
                {{ comment.page.title }} Some other texts here also to elongate
            </a>

        </div>
        <div class="text-sm text-gray-800 px-4 mb-4">{{ comment.body }}</div>
        <div class="flex items-center justify-between p-4 bg-gray-100 border-t">
            <div class="flex items-center">
                <UserStrip
                    :user="comment.user"
                    image-class="h-6 w-6 rounded-full"
                    :show-role="false"
                    :show-name='false'
                ></UserStrip>

                <span class="text-xs text-gray-600 -ml-4">{{ comment.created_ago }}</span>
            </div>

            <div class='w-4 h-4 hover:text-red-600 cursor-pointer' @click='deleteComment'>
                <icon-trash />
            </div>


        </div>


    </div>
</template>
<script>
import UserStrip from './UserStrip.vue'
import IconTrash from './icons/IconTrash'

export default {
    props: {
        comment: {
            type: Object,
        },

    },
    components: { IconTrash, UserStrip },
    methods: {
        deleteComment() {
            let p = this
            util.confirm("Un-publish comment?", "The comment will be deleted from the page", () => {
                util.ajax('delete', '/api/comments/pages/' + this.comment.id, {}, () => {
                    p.$emit('deleted', p.comment.id)
                })
            })
        }
    }
}
</script>
