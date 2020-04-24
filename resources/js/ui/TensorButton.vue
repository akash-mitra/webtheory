<template>

    <button

        class="py-2 px-6 outline-none text-white rounded shadow focus:outline-none"
        :class="'text-'+textSize + ' bg-'+compColor+'-500 hover:bg-'+compColor+'-600'"
    >
        <div class="flex items-center">


            <t-loader v-if="loadingWheel" size="24" style="position: relative; top: 0"></t-loader>

            <slot v-else></slot>
        </div>
    </button>

</template>

<script>

export default {
    props: {
        color: { type: String, default: 'blue' },
        textSize: { type: String, default: 'xs' },
        loadingWheel: { type: Boolean, default: false }
    },

    computed: {
        compColor() {
            return this.loadingWheel ? 'gray' : this.color
        }
    }
}

</script>