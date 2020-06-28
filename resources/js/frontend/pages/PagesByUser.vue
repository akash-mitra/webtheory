<template>

    <div v-if="userPagesData.hasOwnProperty('data') && userPagesData.data.length>0">

        <Paginator
            :page-data="userPagesData"
            @next="loadUserPages"
            @previous="loadUserPages"
            container-class="w-full px-6 md:flex md:flex-wrap md:items-start md:justify-between"
            nav-class="w-full mt-4 p-4 flex justify-between items-center border-t">

                <template v-slot:default="data">
                    <PageTile :page="data.item" :linkColorClass="linkColorClass"></PageTile>
                </template>

        </Paginator>

    </div>

</template>

<script>

import PageTile from './PageTile.vue'
import Paginator from '../../components/Paginator.vue'
import * as Tensor from '../helpers/tensor.js'

export default {

    name: 'pages-by-user',

    props: {
        user: {
            type: Object
        },

        showDraft: {
            type: Boolean,
            default: false,
        },

        linkColorClass: {
            type: String,
            default: 'text-blue-600'
        },
    },

    data() {

        return {
            userPagesData: {}
        }
    },

    components: {
        Paginator,
        PageTile
    },

    created() {

        this.loadUserPages()
    },

    methods: {

        loadUserPages(url) {

            url = typeof url === 'undefined' ? '/api/profiles/' + this.user.public_id + '/pages' : url

            Tensor.xget(url, (response) => this.userPagesData = response)
        },
    }
}
</script>