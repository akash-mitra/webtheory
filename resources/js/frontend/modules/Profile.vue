<template>
    <div>

        <UserTile v-if="mode==='read'"
            :user="user"
            :class="userTileClass"
            class="w-full rounded-lg shadow"
        ></UserTile>


        <div v-if="showEditor && mode==='edit'">
            <UserProfileEditor
                :user="user"
                :class="editorTileClass"
                @saved="onSave"
                @cancelled="mode='read'">
            </UserProfileEditor>
        </div>

        <div v-if="showEditor && mode==='read'" class="text-right p-3">
            <span id="update-profile" class="cursor-pointer" :class="linkColorClass" @click="mode='edit'">Update Profile Data</span>
        </div>



        <PagesByUser
            :user="user"
            class="my-4 rounded-lg"
            :class="pagesTileClass"
            :link-color-class="linkColorClass"
            v-if="showPages && mode==='read'">
        </PagesByUser>

    </div>
</template>

<script>

import UserTile from '../users/UserTile.vue'
import UserProfileEditor from '../users/UserProfileEditor.vue'
import PagesByUser from '../pages/PagesByUser.vue'

export default {

    props: {
        profile: {
            type: Object
        },

        showEditor: {
            type: Boolean,
            default: false
        },

        showPages: {
            type: Boolean,
            default: true
        },

        showComments: {
            type: Boolean,
            default: false
        },

        userTileClass: {
            type: String,
            default: 'bg-gray-100 text-gray-800'
        },

        editorTileClass: {
            type: String,
            default: 'bg-gray-100 text-gray-800'
        },

        pagesTileClass: {
            type: String,
            default: 'bg-gray-100 text-gray-800'
        },

        linkColorClass: {
            type: String,
            default: 'text-blue-800'
        },
    },

    data() {
        return {
            user: this.profile,
            mode: 'read',
        }
    },

    components: {
        UserTile,
        PagesByUser,
        UserProfileEditor,
    },

    methods: {
        onSave(user) {
            user.avatar += '?cachebuster=' + Math.floor(Math.random() * Math.floor(100))
            this.user = user
            this.$root.authuser = user
            this.mode = 'read'
            // this.$emit('userupdated', user)
        },
    },
}
</script>
