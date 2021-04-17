<template>
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <a v-if="showAvatar" :href="'/app/users/' + user.id">
                <img :src="user.avatar" :class="imageClass" :title='user.name'/>
            </a>
        </div>
        <div class="mx-4">
            <div v-if="showName" :class="userClass">{{ user.name }}</div>
            <div v-if="showRole" :class="roleClass">{{ user.role.toUpperCase() }}</div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        user: {
            type: Object,
        },
        showAvatar: {
            type: Boolean,
            default: true
        },
        showName: {
            type: Boolean,
            default: true
        },
        showRole: {
            type: Boolean,
            default: true
        },
        imageClass: {
            type: String,
            default: 'h-12 w-12 rounded-full border',
        },
        userClass: {
            type: String,
            default: 'text-sm text-gray-700 font-bold',
        },
        roleClass: {
            type: String,
            default: 'text-xs tracking-wide text-gray-600',
        },
    },
}
</script>
