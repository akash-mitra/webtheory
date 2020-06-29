<template>

<div class="w-full sm:flex justify-between items-center p-4 border-b">

    <div class="w-full sm:w-1/2 flex">
        <router-link :id="'show-user-' + user.id" :to="{name: 'users.edit', params: { id: user.id }}" class="text-blue-600 hover:text-blue-900 focus:outline-none focus:underline">
            <img v-if="user.avatar" class="block h-10 w-10 rounded-full" :src="user.avatar" alt="" />

            <svg v-else class="w-8 h-8 rounded-full border text-gray-700" viewBox="0 0 20 20">
                <path class="fill-current" d="M10,10.9c2.373,0,4.303-1.932,4.303-4.306c0-2.372-1.93-4.302-4.303-4.302S5.696,4.223,5.696,6.594C5.696,8.969,7.627,10.9,10,10.9z M10,3.331c1.801,0,3.266,1.463,3.266,3.263c0,1.802-1.465,3.267-3.266,3.267c-1.8,0-3.265-1.465-3.265-3.267C6.735,4.794,8.2,3.331,10,3.331z"></path>
                <path class="fill-current" d="M10,12.503c-4.418,0-7.878,2.058-7.878,4.685c0,0.288,0.231,0.52,0.52,0.52c0.287,0,0.519-0.231,0.519-0.52c0-1.976,3.132-3.646,6.84-3.646c3.707,0,6.838,1.671,6.838,3.646c0,0.288,0.234,0.52,0.521,0.52s0.52-0.231,0.52-0.52C17.879,14.561,14.418,12.503,10,12.503z"></path>
            </svg>
        </router-link>

        <div class="ml-4">
            <div class="text-sm leading-5 font-medium text-gray-700">{{ user.name }}</div>
            <div class="text-sm leading-5 text-gray-500 flex items-center">
                {{ user.email }}

                <div v-if="user.email_verified_at == null" class="tooltip text-red-400">
                <svg xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4 ml-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h0"/></svg>
                <span class="tooltip-text bg-red-100 border border-red-200 mb-1 text-red-600 px-3 py-1 rounded-lg text-xs">Email Not Verified</span>
                </div>
            </div>
        </div>
    </div>


    <div class="hidden sm:block w-1/6">
        <div class="text-sm leading-5 text-gray-700">Joined {{ user.created_ago }}</div>
    </div>


    <div class="w-1/6 sm:text-right mt-2 sm:mt-0">

        <span v-if="user.role === 'admin'" class="bg-red-100 px-2 text-red-600 py-1 rounded-lg text-sm">
            Admin
        </span>

        <span v-else-if="user.role === 'author'" class="bg-blue-100 text-blue-600 px-2 py-1 rounded-lg text-sm">
            Author
        </span>

        <span v-else class="bg-gray-100 px-2 py-1 text-gray-700 rounded-lg text-sm">
            Member
        </span>
    </div>


    <div v-if="canBan" class="w-full sm:w-1/6 flex justify-end sm:px-6">
        <div :id="'remove-ban-user-' + user.id" v-if="!!user.deleted_at" @click="$emit('unbanned', user.id)" class="tooltip cursor-pointer text-red-600 hover:text-red-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M5 5l14 14"/></svg>
            <span class="tooltip-text bg-black text-white mb-2 rounded-lg text-xs py-1">Remove Ban</span>
        </div>

        <div :id="'ban-user-' + user.id" v-else @click="$emit('banned', user.id)" class="tooltip cursor-pointer text-gray-400 hover:text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M5 5l14 14"/></svg>
            <span class="tooltip-text bg-black text-white mb-2 rounded-lg text-xs py-1">Ban User</span>
        </div>
    </div>

</div>


</template>

<script>
export default {
    props: {
        user: {
            type: Object
        },
        canBan: {
            type: Boolean,
            default: true
        }
    },
}

</script>