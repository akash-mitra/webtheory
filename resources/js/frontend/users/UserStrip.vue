<template>
    <div class="relative inline-block cursor-pointer focus:outline-none" @click.stop tabindex="-10">

        <div @click="openMe" class="inline-flex justify-center items-center w-full rounded py-2 text-sm font-medium transition ease-in-out duration-150">
            <span class="flex items-center px-4">
                <img :src="user.avatar" class="h-12 w-12 rounded-full border-2" />
                <span class="hidden sm:flex ml-4 text-lg text-gray-800">{{ user.name }}</span>
            </span>
            <svg class="ml-1 pr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>

        <div v-if="userMenuOpen" class="origin-top-right absolute right-0 w-56 rounded shadow-lg">
            <div class="rounded bg-white border shadow-xs">

            <div class="border-b" v-if="user.email_verified_at != null">
                <div class="flex px-4 py-4 tracking-wide text-gray-700">
                    <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 24 24">
                        <desc>Email Not Verified</desc>
                        <title>Email Not Verified</title>
                        <path class="text-red-200" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"/>
                        <path class="text-red-600" d="M12 18a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm1-5.9c-.13 1.2-1.88 1.2-2 0l-.5-5a1 1 0 0 1 1-1.1h1a1 1 0 0 1 1 1.1l-.5 5z"/>
                    </svg>
                    Email Not Verified
                </div>
            </div>

            <div class="border-b">
                <a :href="user.url" class="flex justify-between items-center px-4 py-4 tracking-wide text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900">
                    <span>Profile</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </a>
            </div>


            <div class="border-b" v-if="user.role === 'admin' || user.role === 'author'">
                <a href="/app" target="_blank" class="flex justify-between items-center px-4 py-4 tracking-wide text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900">
                    <span>Control Panel</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                </a>
            </div>


            <div class="border-b" v-if="editPageLink">
                <a :href="editPageLink" target="_blank" class="flex justify-between items-center px-4 py-4 tracking-wide text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900">
                    <span>Edit this page</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </a>
            </div>

            <div class="bg-gray-100">

                    <button type="submit" @click="logout" class="flex justify-between items-center px-4 py-4 tracking-wide w-full text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900">
                        <span class="mr-3">Logout</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    </button>

            </div>

        </div>
        </div>
    </div>

</template>

<script>

export default {
    props: {
        userMenuOpen: {
            type: Boolean,
            default: false
        },

        user: {
            type: Object,
        },

        editPageLink: {
            type: String,
            default: null
        },
    },

    methods: {
        closeMe() {
            this.$emit('user-strip-close')
        },

        openMe() {
            this.$emit('user-strip-open')
        },

        logout() {
            this.$emit('logout')
        }
    },
}
</script>