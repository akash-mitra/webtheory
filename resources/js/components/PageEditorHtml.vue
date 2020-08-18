<template>
    <div class="w-full max-w-2xl mx-auto">
        <textarea
            class="w-full border p-3 rounded-lg"
            :value="value"
            @input="$emit('input', $event.target.value)"
        ></textarea>
    </div>
</template>

<script>
export default {
    props: ['value'],
}
</script>
