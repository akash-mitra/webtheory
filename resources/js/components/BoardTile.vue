<template>
    <div class="w-1/2 sm:w-1/4 xl:w-1/2 p-2 lg:p-3">
        <div class="rounded-lg shadow px-6 py-4" :class="tileClass">
            <div
                class="text-3xl sm:text-4xl lg:text-5xl xl:text-5xl font-bold text-right"
                :class="metricClass"
            >
                <div v-if="loading">...</div>
                <slot v-else name="metric"></slot>
            </div>
            <div class="">
                <div class="text-normal md:text-lg xl:text-2xl text-right" :class="textClass">
                    <slot name="header"></slot>
                </div>
                <div class="text-sm md:text-normal xl:text-lg text-right" :class="ctaClass">
                    <slot name="text"></slot>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        loading: {
            type: Boolean,
            default: false,
        },
        tileClass: {
            type: String,
            default: 'bg-blue-500',
        },
        metricClass: {
            type: String,
            default: 'text-white',
        },
        textClass: {
            type: String,
            default: 'text-blue-100',
        },
        ctaClass: {
            type: String,
            default: 'text-blue-200',
        },
    },
}
</script>
