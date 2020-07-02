<template>
    <div>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6 text-blue-600 mr-6"
            @click="templateUploadModal = true"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        >
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line>
        </svg>


        <t-modal
            :show="templateUploadModal"
            cover="1/2"
            @close="templateUploadModal=false"
            @go-ahead="submitFileToServer"
        >
                <template v-slot:header>
                    <div class="w-full px-6 py-4 border-b">
                        <h3 class="text-gray-800 text-xl">Upload Template Files</h3>
                    </div>
                </template>



                <div class="pt-4 px-6 w-full">

                    <div class="text-sm">
                        Create a new template by uploading a single archieve file (.zip file)
                        that contains all the template files inside it.
                    </div>

                    <div class="w-full px-6 py-2 my-2 bg-gray-100 rounded-lg">

                        <div class="">
                            <label class="py-2 block text-gray-800">Template Name</label>
                            <input type="text" class="block w-full px-3 py-1 border rounded" v-model="name" placeholder="Template Name">
                            <div class="text-sm text-gray-600 italic mt-1">Template name can only contain letters, numbers, underscore and dash</div>
                        </div>

                        <div class="mt-2">
                            <label class="py-2 block text-gray-800">Template Zip file</label>
                            <input type="file" class="py-2 text-blue-600" name="file" ref="inputfile" accept=".svg,.zip">

                        </div>
                    </div>


                    <div class="text-sm text-red-400" v-if="message">{{ message }}</div>

                </div>



        </t-modal>

    </div>

</template>

<script>

    export default {
        data() {
            return {
                name: '',
                templateUploadModal: false,
                message: null,
            }
        },
        methods: {

            submitFileToServer() {

                if (this.$refs.inputfile.files.length != 1) {
                    this.message = 'Please select a single .zip file for uploading.'
                } else {

                    let file = this.$refs.inputfile.files[0],
                        formData = new FormData(), p = this

                    formData.append('file', file)
                    formData.append('name', this.name)

                    util.ajax ('post', '/api/templates/upload', formData, function (response) {
                        p.templateUploadModal = false
                        util.notifySuccess('New Template Created', 'Template ' + p.name + ' has been created from the uploaded zip')
                    })
                }

            }
        }
    }
</script>