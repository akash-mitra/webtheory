<template>
    <div class="max-w-5xl mx-auto">
        <div
            class="px-2 my-6 w-full pt-6"
        >
            <div class="flex justify-center items-center flex-col">
                <img v-if="avatar" :src="avatar" class="rounded-full mr-4 h-48 w-48 border" />
                <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    class="rounded-full mr-4 h-48 w-48 fill-current"
                >
                    <g>
                        <path
                            class="text-yellow-100"
                            d="M3.66 17.52a10 10 0 1 1 16.68 0C19.48 16.02 17.86 16 16 16H8c-1.86 0-3.48.01-4.34 1.52z"
                        />
                        <path
                            class="text-blue-200"
                            d="M3.66 17.52A5 5 0 0 1 8 15h8a5 5 0 0 1 4.34 2.52 10 10 0 0 1-16.68 0zM12 13a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"
                        />
                    </g>
                </svg>
                <div class='w-full'>
                    <h2 class="text-gray-800 text-3xl w-full text-center">{{ name }}</h2>
                    <p class="text-gray-600 w-full text-center">
                        <span
                            v-if="role === 'registered'"
                            class="mr-2 bg-gray-100 text-green-700 px-2 border border-green-500 rounded uppercase text-xs tracking-wider font-bold"
                            >{{ role }}</span
                        >
                        <span
                            v-if="role === 'author'"
                            class="mr-2 bg-gray-100 text-indigo-700 px-2 border border-indigo-500 rounded uppercase text-xs tracking-wider font-bold"
                            >{{ role }}</span
                        >
                        <span
                            v-if="role === 'admin'"
                            class="mr-2 bg-gray-100 text-red-700 px-2 border border-red-500 rounded uppercase text-xs tracking-wider font-bold"
                            >{{ role }}</span
                        >
                        <span v-if="created_ago">Joined {{ created_ago }}.</span>
                    </p>
                </div>
            </div>

            <div class="flex justify-center mt-8">
                <t-button color="gray" @click.native="$router.push({ name: 'users.index' })">
                    Close
                </t-button>

                &nbsp;

                <t-button
                    v-if="showSaveButton"
                    :loadingWheel="isSaving"
                    @click.native="initiateSave"
                >
                    Save
                </t-button>
            </div>
        </div>

        <div class="w-full bg-white border-t rounded">

            <div class="w-full sm:flex px-6 pt-8">
                <label for="userName" class="block w-full sm:w-1/6 sm:text-right text-sm py-1 px-3"
                    >Name</label
                >

                <div class="w-full my-1 w-full max-w-lg">
                    <input
                        type="text"
                        id="userName"
                        v-model="name"
                        ref="name"
                        class="w-full px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                    />
                    <div
                        v-if="errors && errors.hasOwnProperty('name')"
                        class="w-full block text-xs text-red-400"
                    >
                        {{ errors.name[0] }}
                    </div>
                </div>
            </div>

            <div class="w-full sm:flex px-6 pt-6">
                <label for="userEmail" class="block w-full sm:w-1/6 sm:text-right text-sm py-1 px-3"
                    >Email</label
                >
                <div class="w-full my-1 w-full max-w-lg">
                    <input
                        type="email"
                        id="userEmail"
                        v-model="email"
                        ref="email"
                        class="w-full px-2 py-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                    />
                    <div
                        v-if="errors && errors.hasOwnProperty('email')"
                        class="w-full block text-xs text-red-400"
                    >
                        {{ errors.email[0] }}
                    </div>
                </div>
            </div>

            <div class="w-full sm:flex px-6 pt-6">
                <label for="userRole" class="block w-full sm:w-1/6 sm:text-right text-sm py-1 px-3"
                    >Role</label
                >
                <div class="inline-block relative w-full max-w-lg">
                    <select
                        id="role"
                        v-model="role"
                        ref="role"
                        class="block appearance-none w-full bg-white px-2 py-1 pr-8 rounded border focus:outline-none"
                    >
                        <option
                            v-for="role in roles"
                            :value="role.key"
                            :key="role.key"
                            v-text="role.value"
                        ></option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                    >
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                            <path
                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="w-full sm:flex px-6 pt-6">
                <label
                    for="userAboutMe"
                    class="block w-full sm:w-1/6 sm:text-right text-sm py-1 px-3"
                    >About</label
                >
                <textarea
                    type="email"
                    id="userAboutMe"
                    v-model="about_me"
                    ref="about_me"
                    class="w-full w-full h-48 max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"
                ></textarea>
            </div>

            <div class="w-full sm:flex items-center px-6 pt-6">
                <label class="block w-full sm:w-1/6 sm:text-right text-sm py-1 px-3"></label>
                <div v-if="authUserId === id" class="w-full">
                    <span
                        class="px-6 py-2 inline-block text-sm bg-blue-600 rounded hover:bg-blue-700 text-white cursor-pointer"
                        @click="resetPasswordModal = true"
                        >Reset Password</span
                    >
                </div>
            </div>
        </div>

        <t-modal
            :show="resetPasswordModal"
            cover="1/2"
            @close="resetPasswordModal = false"
            @go-ahead="sendResetReq"
        >
            <template v-slot:header>
                <div class="w-full px-6 py-4 border-b">
                    <h3 class="text-gray-800 text-xl">Reset Current Password</h3>
                </div>
            </template>

            <div class="pt-4 w-full">
                <div class="px-6 w-full mb-4">
                    <label
                        for="currrent_password"
                        class="block text-gray-700 text-sm mb-2 flex justify-between"
                    >
                        Current Password
                    </label>

                    <input
                        aria-label="Password"
                        v-model="current_password"
                        id="current_password"
                        type="password"
                        required=""
                        autocomplete="current-password"
                        class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                        placeholder="********"
                    />
                </div>

                <div class="px-6 w-full mb-4">
                    <label
                        for="new_password"
                        class="block text-gray-700 text-sm mb-2 flex justify-between"
                    >
                        New Password
                    </label>

                    <input
                        aria-label="Password"
                        v-model="new_password"
                        id="new_password"
                        type="password"
                        required
                        class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                        placeholder="********"
                    />

                    <label
                        for="new_password_confirrmation"
                        class="block text-gray-700 text-sm my-2 flex justify-between"
                    >
                        Re-type New Password
                    </label>

                    <input
                        aria-label="Password"
                        v-model="new_password_confirmation"
                        id="new_password_confirmation"
                        type="password"
                        required
                        class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                        placeholder="********"
                    />
                </div>
            </div>

            <template v-slot:action-btn-content>
                <span class="px-4 py-2 text-white bg-indigo-600 rounded">Change Password</span>
            </template>
        </t-modal>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            isSaving: false,
            sourceCode: null,
            id: 0,
            name: null,
            email: null,
            role: null,
            avatar: null,
            created_ago: null,
            gender: null,
            about_me: null,
            dob: null,

            roles: [
                { key: 'admin', value: 'Administrator' },
                { key: 'author', value: 'Author' },
                { key: 'registered', value: 'Registered' },
            ],

            resetPasswordModal: false,
            token: token,
            current_password: '',
            new_password: '',
            new_password_confirmation: '',

            authUserId: this.$root.authUser.id,
            authUserRole: this.$root.authUser.role,
            errors: null,
        }
    },

    created() {
        this.fetchUserAndLoadForm()
    },

    computed: {
        showSaveButton() {
            if (this.authUserRole === 'admin') return true

            return false
        },
    },

    methods: {
        // simple front-end validations before starting
        // the saving process. Mandatory fields checking.
        isValid: function () {
            if (!this.name) {
                util.notifyError('User has no name', 'Provide a name for this user')
                return false
            }

            if (!this.email) {
                util.notifyError('User has no email', 'Provide an email for this user')
                return false
            }

            if (this.name.length >= 255) {
                util.notifyError('User name too long!', 'Keep name within maximum 255 characters.')
                return false
            }

            if (this.name.email >= 255) {
                util.notifyError(
                    'User email too long!',
                    'Keep email within maximum 255 characters.'
                )
                return false
            }

            if (!this.role) {
                util.notifyError(
                    'User must have a role',
                    'Select any one role for this user, e.g. "Admin" or "Author" etc.'
                )
                return false
            }

            return true
        },

        getSaveUrl: function () {
            if (this.id > 0) return '/api/users/' + this.id
            else return '/api/users'
        },

        getSaveMethod: function () {
            if (this.id > 0) return 'put'
            else return 'post'
        },

        initiateSave: function () {
            if (this.isValid()) {
                this.isSaving = true

                let p = this
                util.ajax(
                    this.getSaveMethod(),
                    this.getSaveUrl(),
                    {
                        id: this.id,
                        name: this.name,
                        email: this.email,
                        role: this.role,
                        about_me: this.about_me,
                    },
                    this.postSaveProcessing,
                    function (statusCode, data) {
                        if (statusCode === 422) {
                            p.errors = data.errors
                        }
                    }
                )
            }
        },

        /*--------------------------------------------------------------------------
         * Processes the Id after a successful saving
         */
        postSaveProcessing: function (successResponse) {
            if (this.isJustCreated()) {
                // assign new Id
                let id = parseInt(successResponse.id)
                this.id = id

                // change the address bar URL to en edit page url
                this.$router.replace({ path: '/app/users/' + id })
            }

            this.isSaving = false

            util.toast({
                icon: 'success',
                titleText: 'User Saved Successfully',
                // text: 'The user has been saved successfully'
            })
        }, // end of postSaveProcessing

        isJustCreated: function () {
            return this.id === 0
        },

        /**--------------------------------------------------------------------------
         * If the user ID is present (e.g. passed as a URL parameter via router),
         * then this method will make an AJAX query in the server to fetch the
         * contents of the user from the database when Vue is created.
         */
        fetchUserAndLoadForm: function () {
            if (
                typeof this.$route.params.id != 'undefined' &&
                parseInt(this.$route.params.id) > 0
            ) {
                this.sourceCode = 'Retrieving information from the server....'
                let p = this
                util.ajax('get', '/api/users/' + this.$route.params.id, {}, function (data) {
                    // console.log(data);

                    p.id = data.id
                    p.name = data.name
                    p.email = data.email
                    p.role = data.role
                    p.avatar = data.avatar
                    p.created_ago = data.created_ago
                    p.gender = data.gender
                    p.about_me = data.about_me
                    p.dob = data.dob
                })
            }
        },

        sendResetReq() {
            let data = {
                    current_password: this.current_password,
                    new_password: this.new_password,
                    new_password_confirmation: this.new_password_confirmation,
                },
                p = this

            util.ajax('patch', '/api/users/password', data, function (response) {
                util.notifySuccess(response.message, 'Your current session will be logged out.')
                p.$root.logoutDirect()
            })
        },
    },
}
</script>
