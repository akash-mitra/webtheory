<template>

    <div class="max-w-4xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">
                Users
                <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{ users.length }}</span>
            </h2>

            <a href="/app/users/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">Create</a>

        </div>

        <div class="px-6">
            <input type="text"
                class="w-full rounded-lg shadow px-4 py-3 text-sm focus:outline-none"
                name="search"
                placeholder="Search by user name or email..."
                v-model="searchPhrase"
            />
        </div>

        <div class="p-6">

            <div class="flex flex-col">
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-blue-200 bg-blue-50 text-left text-xs leading-4 font-medium text-blue-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 border-b border-blue-200 bg-blue-50 text-left text-xs leading-4 font-medium text-blue-500 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th class="px-6 py-3 border-b border-blue-200 bg-blue-50 text-left text-xs leading-4 font-medium text-blue-500 uppercase tracking-wider">
                                        Verified
                                    </th>
                                    <th class="px-6 py-3 border-b border-blue-200 bg-blue-50 text-left text-xs leading-4 font-medium text-blue-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th class="px-6 py-3 border-b border-blue-200 bg-blue-50"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr v-for="user in filteredUsers" :key="user.id">
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img v-if="user.avatar" class="h-10 w-10 rounded-full" :src="user.avatar" alt="" />
                                                <svg v-else class="w-8 h-8 rounded-full border text-gray-700" viewBox="0 0 20 20">
                                                    <path class="fill-current" d="M10,10.9c2.373,0,4.303-1.932,4.303-4.306c0-2.372-1.93-4.302-4.303-4.302S5.696,4.223,5.696,6.594C5.696,8.969,7.627,10.9,10,10.9z M10,3.331c1.801,0,3.266,1.463,3.266,3.263c0,1.802-1.465,3.267-3.266,3.267c-1.8,0-3.265-1.465-3.265-3.267C6.735,4.794,8.2,3.331,10,3.331z"></path>
                                                    <path class="fill-current" d="M10,12.503c-4.418,0-7.878,2.058-7.878,4.685c0,0.288,0.231,0.52,0.52,0.52c0.287,0,0.519-0.231,0.519-0.52c0-1.976,3.132-3.646,6.84-3.646c3.707,0,6.838,1.671,6.838,3.646c0,0.288,0.234,0.52,0.521,0.52s0.52-0.231,0.52-0.52C17.879,14.561,14.418,12.503,10,12.503z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm leading-5 font-medium text-gray-900">{{ user.name }}</div>
                                                <div class="text-sm leading-5 text-gray-500">{{ user.email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-900">Director</div>
                                        <div class="text-sm leading-5 text-gray-500">Human Resources</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <span v-if="user.email_verified_at == null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            No
                                        </span>
                                        <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Yes
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                        {{ user.role }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                        <div class="inline-flex">
                                            <div>
                                                <router-link :to="{name: 'users.edit', params: { id: user.id }}" class="text-blue-600 hover:text-blue-900 focus:outline-none focus:underline">
                                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                        <path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"></path>
                                                    </svg>
                                                </router-link>
                                            </div>
                                            <div class="ml-2">
                                                <a href="javascript:void(0)" @click="deleteUser(user.id)" class="text-blue-600 hover:text-blue-900 focus:outline-none focus:underline">
                                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                        <path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"></path>
                                                    </svg>
                                                </a>
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

    export default {

        data() {
            return {
                users: [],
                selected: null,
                tab: 'all',
                searchPhrase: ''
            }
        },

        created() {
            util.ajax ('get', '/api/users', {},  (response) => { this.users = response })
        },

        computed: {
            filteredUsers ()
            {
                return this.users.filter((user) => {

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

            deleteUser (id) {

                let p = this

                util.confirm ("Delete this user?", "This action can not be reverted", function () {

                    util.ajax ('delete', '/api/users/' + id, {}, (response) => {

                        util.notifySuccess ('Deleted', 'The user has been successfully deleted')

                        for(let index = 0; index < p.users.length; index++) { 
                            if ( p.users[index].id === id ) {
                                p.users.splice(index, 1);
                            }
                        }
                    })

                })

            },
            
        }
    };

</script>