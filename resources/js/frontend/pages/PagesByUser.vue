<template>

    <div class="my-4" v-if="userPagesData.hasOwnProperty('data') && userPagesData.data.length>0">
        <div class="px-12 pt-3 text-xl uppercase text-gray-700">
            Pages Created by {{ user.name }}
        </div>

        <div class="rounded-lg -mt-4">

            <Paginator
                :page-data="userPagesData"
                @next="loadUserPages"
                @previous="loadUserPages"
                container-class="w-full px-6 md:flex md:flex-wrap md:items-start md:justify-between"
                nav-class="w-full mt-4 p-4 flex justify-between items-center bg-gray-100">

                    <template v-slot:default="data">
                        <PageTile :page="data.item" v-if="showDraft || data.item.status != 'Draft'"></PageTile>
                    </template>

            </Paginator>

        </div>

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