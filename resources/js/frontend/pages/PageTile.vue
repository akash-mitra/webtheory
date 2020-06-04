<template>
    <div class="w-full p-3">
        <div @click="navigateTo(page.url)" class="text-2xl text-blue-600 py-3 cursor-pointer hover:text-blue-800 font-heading">
            {{ page.title }}
        </div>

        <div class="w-full">
            <img v-if="page.media != null" :src="page.media.url" class="w-full object-cover" style="max-height: 12rem">
            <img v-else src="https://source.unsplash.com/random/400x300" class="w-full object-cover" style="max-height: 12rem">

        </div>

        <div class="w-full py-3">
            <div class="text-gray-600 font-reading">{{ page.summary }}</div>
        </div>

        <div @click="navigateTo(page.url)" class="py-3 text-blue-600 cursor-pointer hover:text-blue-800">
            Read More...
        </div>

    </div>
</template>


<script>
export default {
    props: {
        page: {
            type: Object,
        }
    },

    methods: {
        navigateTo(url) {
            window.location.href = url
        }
    }
}
</script>