<template>
    <div class="flex flex-col justify-between">
        <div class="text-sm text-gray-800 p-4">{{ comment.body }}</div>

        <div class="flex items-center p-4 bg-gray-100 justify-between border-t">
            <UserStrip
                :user="comment.user"
                image-class="h-6 w-6 rounded-full"
                role-class="hidden"
            ></UserStrip>

            <span class="text-sm text-gray-800">Commented {{ comment.created_ago }}</span>
        </div>
    </div>
</template>
<script>
import UserStrip from './UserStrip.vue'
export default {
    props: {
        comment: {
            type: Object,
        },
    },
    components: { UserStrip },
}
</script>
