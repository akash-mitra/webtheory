<template>

    <button 
        
        class="py-2 px-6 outline-none text-white rounded shadow focus:outline-none"
        :class="'text-'+textSize + ' bg-'+compColor+'-500'"
    >
        <div class="flex items-center">
            

            <t-loader v-if="isLoading" size="24" style="position: relative; top: 0"></t-loader>
            
            <slot v-else></slot>
        </div>
    </button>

</template>

<script>

export default {
    props: {
        color: { type: String, default: 'blue' },
        textSize: { type: String, default: 'xs' },
        isLoading: { type: Boolean, default: false }
    },

    computed: {
        compColor() {
            return this.isLoading ? 'gray' : this.color
        }
    }
}

</script>