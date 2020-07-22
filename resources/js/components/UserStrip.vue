<template>
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <img :src="user.avatar" :class="imageClass" />
        </div>
        <div class="mx-4">
            <div :class="userClass">{{ user.name }}</div>
            <div :class="roleClass">{{ user.role.toUpperCase() }}</div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        user: {
            type: Object,
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
