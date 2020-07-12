<template>
    <div class="w-full bg-white mt-4 text-sm rounded shadow">
        <div class="w-full flex p-2 border-b bg-gray-100">
            <div class="w-1/4 uppercase text-xs text-gray-600">Response #</div>
            <div class="w-3/4">{{ feedback.id }}</div>
        </div>

        <div v-for="(value, name) in fields" class="w-full flex p-2 border-b">
            <div class="w-1/4 uppercase text-xs text-gray-600">{{ name }}</div>
            <div class="w-3/4">{{ value }}</div>
        </div>

        <div class="w-full flex p-2 border-b bg-gray-100">
            <div class="w-1/4 uppercase text-xs text-gray-600">Receive Timestamp</div>
            <div class="w-3/4">{{ feedback.created_at }}</div>
        </div>
        <div class="w-full flex p-2 border-b bg-gray-100">
            <div class="w-1/4 uppercase text-xs text-gray-600">From IP</div>
            <div class="w-3/4">{{ feedback.ip }}</div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        feedback: {
            type: Object,
        },
    },

    computed: {
        fields() {
            return JSON.parse(this.feedback.responses)
        },
    },
}
</script>
