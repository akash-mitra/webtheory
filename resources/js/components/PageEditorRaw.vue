<template>
    <div class="w-full">
        <textarea class="w-full border p-3 rounded-lg" v-model="content.body_html"></textarea>
    </div>
</template>

<script>
export default {
    props: ['content'],
}
</script>
