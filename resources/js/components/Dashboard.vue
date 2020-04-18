<template>

    <div class="max-w-4xl mx-auto">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">Dashboard <span class="ml-3 rounded-lg py-1 px-2 shadow-inner text-xs bg-gray-300">{{ pages.length }}</span></h2>
            <a href="/app/pages/create" class="bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow">New Page</a>
        </div>

        <div class="px-6 w-full flex justify-start items-center my-8 border-b">
            <div @click="tab='all'" class="px-4 text-sm uppercase cursor-pointer" :class="tab==='all'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">All</div>
        </div>

        <div class="px-6">

        </div>

    </div>
</template>

<script>

    export default {

        data() {
            return {

                tab: 'all',

            }
        },

        created() {

        },
    }

</script>
