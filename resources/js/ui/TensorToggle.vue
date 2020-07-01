<template>

    <div @click="toggle" class="flex items-center cursor-pointer">

        <div class="flex items-center" :class="boxClass + (value === trueValue ? ' justify-start' : ' justify-end')">
            <div :class="value === trueValue ? trueClass : falseClass">
                <span v-if="showValue">{{ value }}</span>
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

        boxClass: {
            type: String,
            default: 'w-12 h-4 bg-gray-200 border border-blue-200 rounded-lg'
        },

        trueClass: {
            type: String,
            default: 'rounded-full h-4 w-4 shadow bg-blue-400'
        },

        falseClass: {
            type: String,
            default: 'rounded-full h-4 w-4 shadow bg-gray-400'
        },

        showValue: {
            type: Boolean,
            value: false
        },

        // disabled: {
        //     type: Boolean,
        //     default: false
        // },
    },



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