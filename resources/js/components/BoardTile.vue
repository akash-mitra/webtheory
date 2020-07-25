<template>
    <div class="w-1/2 sm:w-1/4 xl:w-1/2 p-2 lg:p-3">
        <div :class="tileClass + ' bg-' + tileColor + '-500'">
            <div :class="metricClass + ' text-white'">
                <slot name="metric"></slot>
            </div>
            <div class="">
                <div :class="headerClass + ' text-' + tileColor + '-100'">
                    <slot name="header"></slot>
                </div>
                <div :class="textClass + ' text-' + tileColor + '-200'">
                    <slot name="text"></slot>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        tileColor: {
            type: String,
            default: 'blue',
        },
        tileClass: {
            type: String,
            default: 'rounded-lg shadow px-6 py-4',
        },
        metricClass: {
            type: String,
            default: 'text-3xl sm:text-4xl lg:text-5xl xl:text-5xl font-bold text-right',
        },
        headerClass: {
            type: String,
            default: 'text-normal md:text-lg xl:text-2xl text-right',
        },
        textClass: {
            type: String,
            default: 'text-sm md:text-normal xl:text-lg text-right',
        },
    },
}
</script>
