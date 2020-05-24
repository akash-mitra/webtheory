<template>
    <div class="w-full my-6 max-w-4xl mx-auto">

         <h2 class="text-gray-600 text-2xl flex items-center">
                Media Gallery

        </h2>

        <VueImageBrowser source="/api/media" deletable></VueImageBrowser>

    </div>



</template>

<script>

import VueImageBrowser from '@akashmitra/vue-image-browser'

export default {
    components: {
        VueImageBrowser,
    }
}
</script>
