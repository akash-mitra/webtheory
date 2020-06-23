<template>
    <div>

        <UserTile v-if="mode==='read'"
            :user="user"
            :textColorClass="textColorClass"
        ></UserTile>


        <div v-if="showEditor && mode==='edit'">
            <UserProfileEditor :user="user" @saved="onSave" @cancelled="mode='read'">
            </UserProfileEditor>
        </div>

        <div v-if="showEditor && mode==='read'" class="text-right p-3">
            <span class="text-blue-600 cursor-pointer" @click="mode='edit'">Update Profile Data</span>
        </div>


        <PagesByUser :user="user" v-if="showPages && mode==='read'"></PagesByUser>

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

        textColorClass: {
            type: String,
            default: 'text-gray-200'
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
