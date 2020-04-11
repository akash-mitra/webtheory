<template>

    <div class="max-w-5xl mx-auto">

        <div class="px-2 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">User Editor</h2>
            <t-button :loadingWheel="isSaving" @click.native="initiateSave">
                Save
            </t-button>
        </div>


        <div class="w-full bg-white border-t border-blue-400 rounded mb-12">

            <div class="w-full sm:flex mb-4 px-6 pt-8">
                <label for="userName" class="block w-full sm:w-1/4 text-sm py-1 px-3">Name</label>
                <input type="text" id="userName" v-model="name" ref="name" class="w-full sm:w-3/4 max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
            </div>

            <div class="w-full sm:flex mb-4 px-6 pt-8">
                <label for="userEmail" class="block w-full sm:w-1/4 text-sm py-1 px-3">Email</label>
                <input type="email" id="userEmail" v-model="email" ref="email" class="w-full sm:w-3/4 max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
            </div>

            <div class="w-full sm:flex mb-4 px-6 pt-8 pb-12">
                <label for="userRole" class="block w-full sm:w-1/4 text-sm py-1 px-3">Role</label>
                <div class="inline-block relative w-64">
                    <select id="role" v-model="role" ref="role" class="block appearance-none w-full bg-white px-2 py-1 pr-8 rounded border focus:outline-none">
                        <option v-for="role in roles" :value="role.key" :key="role.key" v-text="role.value"></option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>


        </div>

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
            roles: [
                {'key': 'admin', 'value': 'Administrator'},
                {'key': 'author', 'value': 'Author'},
                {'key': 'registered', 'value': 'Registered'},
            ]
        }
    },


    created() {

        this.fetchUserAndLoadForm()
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
                util.notifyError('User email too long!', 'Keep email within maximum 255 characters.')
                return false
            }

            if (!this.role) {
                util.notifyError('User must have a role', 'Select any one role for this user, e.g. "Admin" or "Author" etc.')
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


                util.ajax (this.getSaveMethod(), this.getSaveUrl(), {
                    id: this.id,
                    name: this.name,
                    email: this.email,
                    role: this.role,
                }, this.postSaveProcessing)

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

            if (typeof this.$route.params.id != 'undefined' && parseInt(this.$route.params.id) > 0) {

                this.sourceCode = 'Retrieving information from the server....'
                let p = this
                util.ajax ('get', '/api/users/' + this.$route.params.id, {}, function (data) {
                    p.id = data.id
                    p.name = data.name
                    p.email = data.email
                    p.role = data.role
                })
            }
        },

    }
}
</script>
