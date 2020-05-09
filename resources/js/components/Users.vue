<template>

    <div class="max-w-4xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">
                Users
                <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{ users.length }}</span>
            </h2>

            <a v-if="authUserRole == 'admin'" href="/app/users/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">Create</a>

        </div>

        <div class="px-6">
            <input type="text"
                class="w-full rounded-lg shadow px-4 py-3 text-sm focus:outline-none"
                name="search"
                placeholder="Search by user name, email or role..."
                v-model="searchPhrase"
            />
        </div>

        <div class="px-6 w-full flex justify-between items-center mt-8">
            <div @click="tab='all'" class="px-4 text-sm uppercase cursor-pointer" :class="tab==='all'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">All</div>

            <div v-if="authUserRole == 'admin'" @click="tab='trashed'" class="px-4 text-sm uppercase cursor-pointer" :class="tab==='trashed'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">Trashed</div>
        </div>

        <div class="px-6">

            <div class="flex flex-col">
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div class="align-middle inline-block min-w-full shadow overflow-hidden border-t border-blue-500">
                        <table class="min-w-full">

                            <tbody class="bg-white">
                                <tr v-for="user in filteredUsers" :key="user.id" :class="user.deleted_at ? 'bg-red-100' : ''">
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <router-link :to="{name: 'users.edit', params: { id: user.id }}" class="text-blue-600 hover:text-blue-900 focus:outline-none focus:underline">
                                                    <img v-if="user.avatar" class="h-10 w-10 rounded-full" :src="user.avatar" alt="" />

                                                    <svg v-else class="w-8 h-8 rounded-full border text-gray-700" viewBox="0 0 20 20">
                                                        <path class="fill-current" d="M10,10.9c2.373,0,4.303-1.932,4.303-4.306c0-2.372-1.93-4.302-4.303-4.302S5.696,4.223,5.696,6.594C5.696,8.969,7.627,10.9,10,10.9z M10,3.331c1.801,0,3.266,1.463,3.266,3.263c0,1.802-1.465,3.267-3.266,3.267c-1.8,0-3.265-1.465-3.265-3.267C6.735,4.794,8.2,3.331,10,3.331z"></path>
                                                        <path class="fill-current" d="M10,12.503c-4.418,0-7.878,2.058-7.878,4.685c0,0.288,0.231,0.52,0.52,0.52c0.287,0,0.519-0.231,0.519-0.52c0-1.976,3.132-3.646,6.84-3.646c3.707,0,6.838,1.671,6.838,3.646c0,0.288,0.234,0.52,0.521,0.52s0.52-0.231,0.52-0.52C17.879,14.561,14.418,12.503,10,12.503z"></path>
                                                    </svg>
                                                </router-link>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm leading-5 font-medium text-gray-700">{{ user.name }}</div>
                                                <div class="text-sm leading-5 text-gray-500 flex">
                                                    {{ user.email }}
                                                    <svg v-if="user.email_verified_at == null" class="h-6 w-6 fill-current ml-2" viewBox="0 0 24 24">
                                                        <desc>Email Not Verified</desc>
                                                        <title>Email Not Verified</title>
                                                        <path class="text-red-200" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"/>
                                                        <path class="text-red-600" d="M12 18a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm1-5.9c-.13 1.2-1.88 1.2-2 0l-.5-5a1 1 0 0 1 1-1.1h1a1 1 0 0 1 1 1.1l-.5 5z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="hidden md:table-cell px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-700">{{ user.created_ago }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-700">
                                        {{ user.role.charAt(0).toUpperCase() + user.role.slice(1) }}
                                    </td>

                                    <td v-if="authUserRole == 'admin'" class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                        <div class="inline-flex">

                                            <div class="ml-2">
                                                <button  v-if="user.deleted_at === null" @click="deactivateUser(user.id)" class="text-gray-400 hover:text-red-600">
                                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                        <path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"></path>
                                                    </svg>
                                                </button>
                                                <!--
                                                <button  v-else @click="deleteUser(user.id)" class="text-gray-400 hover:text-red-600">
                                                    <svg viewBox="0 0 24 24" class="fill-current h-6 w-6"><path class="primary" d="M9 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                                                        <path class="secondary" d="M15 9h6a1 1 0 0 1 0 2h-6a1 1 0 0 1 0-2zm1 10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"/>
                                                    </svg>

                                                </button>
                                                -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>

    import { getAuthUserRole } from './../auth.js';

    export default {

        data() {
            return {
                users: [],
                selected: null,
                tab: 'all',
                searchPhrase: '',
                authUserRole: null
            }
        },

        created() {
            util.ajax ('get', '/api/users', {},  (response) => { this.users = response })
            
            this.authUserRole = getAuthUserRole();
        },

        computed: {
            filteredUsers ()
            {
                return this.users.filter((user) => {

                    if(this.tab === 'trashed' && ! user.deleted_at) return false

                    if(this.tab === 'all' &&  user.deleted_at) return false

                    if (!!this.searchPhrase) {
                        let name = user.name.toLowerCase()
                        let email = user.email.toLowerCase()
                        let role = user.role.toLowerCase()
                        let needle = this.searchPhrase.toLowerCase()

                        if (name.indexOf(needle) === -1
                            && email.indexOf(needle) === -1
                            && role.indexOf(needle) === -1)
                                return false
                    }

                    return true
                })
            }
        },


        methods: {

            deactivateUser (id) {

                let p = this

                util.confirm ("De-activate this user?", "The user won't be able to login.", function () {

                    util.ajax ('delete', '/api/users/' + id, {}, (response) => {

                        util.notifySuccess ('De-activated', 'The user has been successfully de-activated.')

                        for(let index = 0; index < p.users.length; index++) {
                            if ( p.users[index].id === id ) {
                                p.users[index].deleted_at = (new Date()).toUTCString()
                            }
                        }
                    })
                })
            },


            deleteUser (id) {

                let p = this

                util.confirm ("Delete this user?", "This action can not be reverted.", function () {

                    util.ajax ('delete', '/api/users/' + id, {"forceDelete": true}, (response) => {

                        util.notifySuccess ('Deleted', 'The user has been successfully deleted from your system.')

                        for(let index = 0; index < p.users.length; index++) {
                            if ( p.users[index].id === id ) {
                                p.users.splice(index, 1)
                            }
                        }
                    })
                })
            },

        }
    };

</script>