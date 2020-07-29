<template>
    <div>
        <div
            class="flex items-center p-2 mb-3 rounded-lg bg-white shadow"
            v-if="isLoading"
            v-for="i in Array(5).keys()"
        >
            <div
                class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 border border-blue-200"
            ></div>
            <div class="ml-4">
                <div class="">
                    <span class="text-gray-200 bg-gray-200">Member's Name Here</span>
                </div>
                <div class="">
                    <span class="text-gray-200 bg-gray-200">Member Type</span>
                </div>
            </div>
        </div>

        <UserStrip
            v-for="(u, index) in paginatedUsers.data"
            :user="u"
            :key="u.id"
            v-if="index < 7"
            class="p-2 mb-3 rounded-lg bg-white shadow"
        ></UserStrip>
    </div>
</template>

<script>
import UserStrip from './UserStrip.vue'

export default {
    data() {
        return {
            paginatedUsers: [],
            isLoading: true,
        }
    },
    components: { UserStrip },
    created() {
        let url = '/api/users'

        this.isLoading = true

        util.ajax('get', url, {}, (response) => {
            this.paginatedUsers = response

            this.isLoading = false
        })
    },
}
</script>
