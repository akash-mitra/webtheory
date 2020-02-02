<template>

    <div class="w-full bg-white shadow border-t border-blue-200 rounded my-4">
        <div class="w-full relative cursor-pointer" @click="openPageEditor(page.id)">
            <div v-if="page.status==='Draft'" class="absolute top-0 mt-4 right-0 mr-8 px-2 py-1 text-xs text-gray-500 bg-white flex items-center border rounded-lg border-gray-500">draft</div>
            <h3 class="px-6 pt-4 text-blue-400 text-sm">{{ page.category ? page.category.name : '' }}</h3>
            <h3 class="px-6 pt-2 text-blue-800 font-semibold text-sm1">{{ page.title }}</h3>
            <div class="px-6 py-4 text-sm text-gray-600">{{ page.summary }}</div>
        </div>

        <div class="px-6 py-2 bg-gray-100 text-xs flex justify-between items-center" @mouseover="selected = page.id" @mouseleave="selected = null">
            <div class="mr-4 text-gray-700 flex items-center">
                <img :src="page.author.avatar" class="h-6 w-6 rounded-full mr-4"/>
                {{ page.author.name }} updated {{ page.updated_ago }}
            </div>
            <div v-show="selected===page.id && page.status != 'Draft'" @click="changeStatus(page, 'Draft')" class="text-blue-600 mr-4 cursor-pointer hover:text-red-600">Unpublish</div>
            <div v-show="selected===page.id && page.status === 'Draft'" @click="changeStatus(page, 'Live')" class="text-blue-600 mr-4 cursor-pointer hover:text-green-600">Publish</div>
        </div>
    </div>

</template>


<script>

export default {

    props: {
        page: {
            type: Object
        }
    },

    data() {
        return {
            selected: null,
        }
    },


    methods: {

        // open a specific page in editor
        openPageEditor (id)
        {
            this.$router.push({ path: '/app/pages/' + id })
        },


        // change the status (Draft / Live) of a specific page
        changeStatus (page, status)
        {
            util.ajax ('put', '/api/pages/' + page.id + '/status', { "status": status }, (response) => {

                page.status = status

                util.toast({
                    icon: 'success',
                    titleText: 'Status Updated',
                    text: ' Page in ' + status + ' mode now.'
                })
            })
        },
    }
}

</script>