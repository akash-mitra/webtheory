<template>
    <div class="max-w-4xl mx-auto mb-12">
        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-indigo-600 text-2xl flex items-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 mr-3"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Users
                <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{
                    paginatedUsers.data.length
                }}</span>
            </h2>

            <a
                v-if="authUserRole == 'admin'"
                href="/app/users/create"
                class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow"
                >Create</a
            >
        </div>

        <div class="px-6 relative">
            <input
                type="text"
                class="w-full rounded-lg shadow px-4 py-3 text-sm focus:outline-none"
                name="search"
                placeholder="Search by user name, email or role..."
                v-model="searchPhrase"
                @keyup="doDelayedSearch"
            />
            <span class="absolute inset-y-0 right-0 pr-12 flex items-center text-gray-700">
                {{ searchStatus }}
            </span>
        </div>

        <div class="px-6 w-full flex justify-start items-center my-8 rounded-lg">
            <div
                id="user-all-tab"
                @click="filterByTab('all')"
                class="px-6 py-2 rounded-l-full text-sm uppercase cursor-pointer"
                :class="
                    tab === 'all' ? 'bg-white shadow-inner' : 'border text-gray-500 bg-gray-100'
                "
            >
                All
            </div>
            <div
                id="user-unverified-tab"
                @click="filterByTab('unverified')"
                class="px-6 py-2 rounded-none text-sm uppercase cursor-pointer flex items-center"
                :class="
                    tab === 'unverified'
                        ? 'bg-white shadow-inner'
                        : 'border text-gray-500 bg-gray-100'
                "
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-3"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4M12 16h0" />
                </svg>
                unverified
            </div>
            <div
                id="user-banned-tab"
                @click="filterByTab('banned')"
                class="px-6 py-2 rounded-r-full text-sm uppercase cursor-pointer flex items-center"
                :class="
                    tab === 'banned' ? 'bg-white shadow-inner' : 'border text-gray-500 bg-gray-100'
                "
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-3"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="12" cy="12" r="10" />
                    <path d="M5 5l14 14" />
                </svg>
                banned
            </div>
        </div>

        <div class="px-6 w-full">
            <Paginator
                :page-data="paginatedUsers"
                @next="fetchFromServer"
                @previous="fetchFromServer"
                container-class="w-full bg-white"
                item-class="w-full"
                nav-class="w-full p-4 flex justify-between items-center bg-gray-100"
            >
                <template v-slot:default="data">
                    <User
                        :user="data.item"
                        :can-ban="authUserRole === 'admin'"
                        @banned="banUser"
                    ></User>
                </template>
            </Paginator>

            <span class="text-sm text-gray-700">{{ searchStatus }}</span>
        </div>
    </div>
</template>

<script>
import Paginator from './Paginator.vue'
import User from './User.vue'

export default {
    data() {
        return {
            paginatedUsers: {
                data: [],
            },
            selected: null,
            tab: 'all',
            searchPhrase: '',
            searchStatus: '',
            authUserRole: this.$root.authUser.role,
        }
    },

    components: {
        Paginator,
        User,
    },

    created() {
        this.fetchFromServer()
    },

    methods: {
        fetchFromServer(url) {
            url =
                typeof url === 'undefined'
                    ? '/api/users/' + (this.tab === 'all' ? '' : this.tab)
                    : url

            let oUrl = new URL(url, location.href)

            oUrl.searchParams.set('query', this.searchPhrase)

            util.ajax('get', oUrl, {}, (response) => {
                this.paginatedUsers = response
                this.searchStatus = ''
            })
        },

        doDelayedSearch(evt) {
            evt = evt ? evt : window.event
            let charCode = evt.which ? evt.which : evt.keyCode

            if (
                charCode === 17 ||
                charCode === 17 ||
                charCode === 18 ||
                charCode === 20 ||
                charCode === 27 ||
                charCode === 37 ||
                charCode === 38 ||
                charCode === 39 ||
                charCode === 40
            ) {
                return
            }

            this.searchStatus = 'searching...'

            if (this.timer) {
                clearTimeout(this.timer)
                this.timer = null
            }

            this.doInstantLocalSearch()

            this.timer = setTimeout(() => this.fetchFromServer(), 500)
        },

        doInstantLocalSearch() {
            let needle = this.searchPhrase.toLowerCase()
            for (let i = 0; i < this.paginatedUsers.data.length; i++) {
                let u = this.paginatedUsers.data[i]
                if (
                    u.name.toLowerCase().indexOf(needle) === -1 &&
                    u.email.toLowerCase().indexOf(needle) === -1
                ) {
                    this.paginatedUsers.data.splice(i, 1)
                }
            }
        },

        filterByTab(tab) {
            this.tab = tab

            this.fetchFromServer()
        },

        banUser(id) {
            let p = this

            util.confirm(
                'Ban this user?',
                "Once banned, the user won't be able to login.",
                function () {
                    util.ajax('delete', '/api/users/' + id, {}, (response) => {
                        util.notifySuccess(
                            'User Banned',
                            'The user has been banned from loggin-in to the site.'
                        )

                        for (let index = 0; index < p.paginatedUsers.data.length; index++) {
                            if (p.paginatedUsers.data[index].id === id) {
                                p.paginatedUsers.data[index].deleted_at = new Date().toUTCString()
                            }
                        }
                    })
                }
            )
        },

        deleteUser(id) {
            let p = this

            util.confirm('Delete this user?', 'This action can not be reverted.', function () {
                util.ajax('delete', '/api/users/' + id, { forceDelete: true }, (response) => {
                    util.notifySuccess(
                        'Deleted',
                        'The user has been successfully deleted from your system.'
                    )

                    for (let index = 0; index < p.paginatedUsers.data.length; index++) {
                        if (p.paginatedUsers.data[index].id === id) {
                            p.paginatedUsers.data.splice(index, 1)
                        }
                    }
                })
            })
        },
    },
}
</script>
