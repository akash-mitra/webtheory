<template>

    <div v-if="errors.hasOwnProperty(field)">
        <ul class="w-full pl-4 list-disc"> <li class="text-sm text-red-600" v-for="e in errors[field]">{{ e }}</li></ul>
    </div>

</template>

<script>

export default {

    props: {
        errors: {
            type: Object,
        },

        field: {
            type: String
        },


    },


    methods: {

    },

}

</script>