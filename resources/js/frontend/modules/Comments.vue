<template>

    <div>
        {{ content }} Comments
    </div>

</template>

<script>

    export default {

        props: {
            content: { required: true, type: String },
        },

        data() {
            return {
                dummy: 'hellow'
            }
        },
    }

</script>

<style scoped>
    p {}
</style>