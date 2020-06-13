<template>

    <div class="w-full bg-white shadow border-t border-blue-300 rounded my-4">
        <div class="w-full relative">

            <div class="absolute top-0 mt-4 right-0 mr-8 text-xs border py-1 px-2 rounded-lg cursor-pointer"
                @click="changeStatus(page, page.status==='Draft'?'Live':'Draft')">

                <div class="flex items-center">
                    <div :class="page.status==='Draft'? 'bg-gray-400':'bg-green-400'" class="rounded-full h-3 w-3 mr-2"></div>
                    <span :class="page.status==='Draft'? 'text-gray-600':'text-green-600'">{{ page.status }}</span>
                </div>
            </div>

            <h3 class="px-6 pt-4 text-blue-400 text-sm">{{ page.category ? page.category.name : '' }}</h3>

            <h3 class="px-6 pt-2 text-blue-800 font-semibold cursor-pointer" @click="openPageEditor(page)">
                {{ page.title }}
            </h3>


            <div class="px-6 py-4 text-sm text-gray-700">{{ page.summary }}</div>
        </div>

        <div class="px-6 py-2 bg-gray-100 text-xs flex justify-between items-center">
            <div class="mr-4 text-gray-700 flex items-center">
                <img :src="page.author.avatar" class="h-6 w-6 rounded-full mr-4"/>
                {{ page.author.name }} updated {{ page.updated_ago }}
            </div>

            <div @click="openPageInNewWindow(page)" class="text-right text-normal text-gray-500 hover:text-blue-700 cursor-pointer">
                # {{ page.id }}
            </div>
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
        openPageEditor (page)
        {
            this.$router.push({ path: '/app/pages/' + page.id })
        },

        openPageInNewWindow (page)
        {
            window.open(page.url,'_blank');
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