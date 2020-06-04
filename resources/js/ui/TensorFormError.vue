<template>


    <div :class="containerClass" v-if="errorBag">
        <div :class="messageClass" v-if="errorBag.message">
            {{ errorBag.message }}
        </div>

        <div  v-for="key in Object.keys(errorBag.errors)">
            <div  v-for="e in errorBag.errors[key]" :class="errorClass">
                {{ e }}
            </div>
        </div>
    </div>

</template>

<script>

export default {
    name: 'tensor-form-error',

    props: {
        errorBag: {
            type: Object,
            default: null
        },

        containerClass: {
            type: String,
            default: 'bg-yellow-100 border border-orange-300'
        },

        messageClass: {
            type: String,
            default: 'p-2 text-red-600'
        },

        errorClass: {
            type: String,
            default: 'px-2 pb-2'
        },
    }
}

</script>