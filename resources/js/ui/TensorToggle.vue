<template>

    <div @click="toggle" class="flex items-center cursor-pointer">

        <div class="w-12 h-4 bg-gray-200 border border-blue-200 rounded-lg flex items-center" :class="value === trueValue ? 'justify-end' : 'justify-start'">

            <div class="rounded-full h-4 w-4 shadow" :class="value === trueValue ? 'bg-blue-400' : 'bg-gray-400'">
            </div>

        </div>

        <slot></slot>    
    </div>

</template>

<script> 

export default {
    
    props: {
        value: { 
            
            type: String, 
            default: 'yes'
        },

        trueValue: {
            type: String,
            default: 'yes'
        },

        falseValue: {
            type: String,
            default: 'no'
        },

        // disabled: {
        //     type: Boolean,
        //     default: false
        // },
    },

    // computed:  {

    //     compVal () {
    //         return this.trueVal === this.value
    //     }
    // },

    // data() {
    //     return {
    //         toggled: this.value
    //     };
    // },

    methods: {

        toggle() {

            // if (this.disabled || e.keyCode === 9) { // not if disabled or tab is pressed
            //     e.stop();
            // }

            // this.toggled = ! this.toggled;

            let newValue = this.value === this.trueValue ? this.falseValue : this.trueValue

            this.$emit("input", newValue);
        
        }
    },

}

</script>