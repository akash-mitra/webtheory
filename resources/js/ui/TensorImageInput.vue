<template>
    <div>

        <img v-if="image" :src="image" :class="imageClass" @click="openUploadDialog">

        <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            class="block stroke-current text-gray-500 cursor-pointer"
            :class="imageClass"
            @click="openUploadDialog"
            width="100"
            height="100"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1"
            stroke-linecap="round"
            stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline>
        </svg>

        <input type="file" style="display: none" ref="tensorImageFileInput" @change="processFileUpload">
    </div>
</template>

<script>

export default {

    name: 'tensor-image-input',

    props: {
        imageUrl: {
            type: String,
            default: null
        },
        imageClass: {
            type: String,
            default: 'w-full'
        },
    },

    data() {
        return {

            image: this.imageUrl
        }
    },

    methods: {
        openUploadDialog() {
            this.$refs.tensorImageFileInput.click()
        },

        processFileUpload(event) {

            let files = event.target.files || event.dataTransfer.files

            if (!files.length)
                return;

            this.createImage(files[0])
        },

        createImage(file) {

            let reader = new FileReader()
            let vm = this

            reader.onload = (e) => {
                vm.image = e.target.result
                vm.$emit('uploaded', e.target.result)
            }

            reader.readAsDataURL(file)
        },

        removeImage (e) {
            this.imageUrl = '';
        }
  }
}
</script>