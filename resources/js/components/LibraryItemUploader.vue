<template>
    <div>
        <span class="bg-indigo-600 h-10 text-white text-sm px-4 py-2 rounded shadow cursor-pointer"
              @click="showUploadBrowser=true">
            Upload
        </span>

        <t-modal
            :show="showUploadBrowser"
            :show-footer="true"
            go-ahead-button-text="Done"
            @close="showUploadBrowser = false"
            @go-ahead="showUploadBrowser = false"
        >
            <template v-slot:header>
                <p class="text-xl text-gray-600 px-6 py-4">Upload from computer</p>
            </template>

            <div class="">
                <vue-dropzone id="dropzone-box" :options="dropzoneOptions" :useCustomSlot=true
                              @vdropzone-success="fileAdded">
                    <div class="w-full flex flex-col items-center justify-center text-center">
                        <h3 class="w-full text-indigo-600 p-6 block text-xl font-extrabold">Drag and drop to upload
                            content!</h3>
                        <div class="w-full text-lg">...or click to select a file from your computer</div>
                    </div>
                </vue-dropzone>
            </div>
        </t-modal>
    </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    name: "LibraryItemUploader",
    components: {
        vueDropzone: vue2Dropzone
    },
    data() {
        return {
            showUploadBrowser: false,
            dropzoneOptions: {
                url: '/api/media',
                thumbnailWidth: 200,
                headers: {
                    'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
                },
                error: (file, response) => {

                    file.previewElement.classList.add("dz-error")
                    file.previewElement.style.width = "200px"
                    file.previewElement.style.height = "200px"

                    let errorMessageRefs = file.previewElement.querySelectorAll("[data-dz-errormessage]")
                    let results = []

                    for (let i = 0; i < errorMessageRefs.length; i++) {
                        let node = errorMessageRefs[i]
                        results.push(node.textContent = response.message)
                    }

                    return results
                }
            },

        }
    },
    methods: {
        fileAdded(file, response) {
            this.$emit('uploaded', response)
        }
    }
}
</script>
