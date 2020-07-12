<template>
    <div>
        <Paginator
            :page-data="responses"
            @next="fetchFromServer"
            @previous="fetchFromServer"
            container-class="w-full"
            item-class=""
            nav-class="w-full p-4 flex justify-between items-center bg-gray-100"
        >
            <template v-slot:default="data">
                <FormResponse :feedback="data.item"></FormResponse>
            </template>
        </Paginator>

        <div class="">{{ message }}</div>
    </div>
</template>

<script>
import Paginator from './Paginator.vue'
import FormResponse from './FormResponse.vue'
export default {
    props: {
        form: {
            type: Number,
        },
    },

    data() {
        return {
            responses: {},
            message: 'Loading data...',
        }
    },

    components: {
        Paginator,
        FormResponse,
    },

    created() {
        this.fetchFromServer()
    },

    methods: {
        fetchFromServer(url) {
            this.message = 'Loading data from server...'
            url = typeof url === 'undefined' ? '/api/forms/' + this.form + '/responses' : url
            util.ajax('get', url, {}, (response) => {
                this.responses = response
                this.message = ''
            })
        },
    },
}
</script>
