<template>
    <div @click="toggle" class="flex items-center cursor-pointer">
        <div
            class="flex items-center"
            :class="boxClass + (value === trueValue ? ' justify-end' : ' justify-start')"
        >
            <div :class="value === trueValue ? trueClass : falseClass">
                <span v-if="showValue">{{
                    value === trueValue ? trueLabel || value : falseLabel || value
                }}</span>
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
            default: 'no',
        },

        trueValue: {
            type: String,
            default: 'yes',
        },

        falseValue: {
            type: String,
            default: 'no',
        },

        trueLabel: {
            type: String,
            default: null,
        },

        falseLabel: {
            type: String,
            default: null,
        },

        boxClass: {
            type: String,
            default: 'w-12 h-4 bg-gray-200 border border-blue-200 rounded-lg',
        },

        trueClass: {
            type: String,
            default: 'rounded-full h-4 w-4 shadow bg-blue-400',
        },

        falseClass: {
            type: String,
            default: 'rounded-full h-4 w-4 shadow bg-gray-400',
        },

        showValue: {
            type: Boolean,
            value: false,
        },
    },

    methods: {
        toggle() {
            let newValue = this.value === this.trueValue ? this.falseValue : this.trueValue

            this.$emit('input', newValue)
        },
    },
}
</script>
