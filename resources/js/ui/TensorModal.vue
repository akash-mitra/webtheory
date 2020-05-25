<template>
        <div v-if="show" @click="closeModal" class="fixed inset-0 z-50" style="background-color: rgba(0,0,0,0.5)">
                <div class="container mx-auto h-full flex justify-center items-center">
                        <div :class="widthClass" @click.stop class="max-h-screen overflow-y-scroll bg-white shadow-lg border border-gray-600">

                                <div class="w-full flex items-center justify-between">
                                        <slot name="header"></slot>
                                        <span @click="closeModal" class="hover:text-gray-800 cursor-pointer p-4 -ml-12">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
                                        </span>
                                </div>

                                <div class="w-full">
                                        <slot></slot>
                                </div>

                                <div class="w-full flex justify-between items-center p-6 bg-gray-100 border-t mt-6">
                                        <button type="button" @click="closeModal">
                                                <slot name="close-btn-content">
                                                        <span  class="text-blue-600 text-sm">
                                                        Cancel
                                                        </span>
                                                </slot>
                                        </button>

                                        <button type="button" @click="startProcess">
                                                <slot name="action-btn-content">
                                                        <span class="px-6 py-2 text-white bg-blue-600 rounded">
                                                        OK
                                                        </span>
                                                </slot>
                                        </button>
                                </div>
                        </div>
                </div>
        </div>
</template>

<script>
    export default {

        props: ['show', 'cover'],

        computed: {

                widthClass: function () {
                        return 'w-5/6 lg:w-' + this.cover
                }
        },

        created: function () {
                document.addEventListener("keydown", (e) => {
                        if (this.show && e.keyCode == 27) {
                                this.closeModal()
                        }
                })
        },

        methods: {
                closeModal() {

                        this.$emit('close')

                },

                startProcess() {
                        this.$emit('go-ahead')
                }
        }
    }
</script>
