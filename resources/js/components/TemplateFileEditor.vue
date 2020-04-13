<template>

    <div class="max-w-5xl mx-auto">

        <div class="px-2 my-6 w-full flex justify-between items-baseline">
            <h2 v-if="mode==='edit'" class="text-gray-600 text-2xl flex items-center">{{ fileName }}</h2>
            <input v-else type='text' v-model="fileName" class="text-gray-600 text-2xl border border-gray-400 p-1 border-b-2 rounded bg-transparent" placeholder="Enter file name"></input>

            <div>
                <t-button color="gray" @click.native="$router.go(-1)">
                    Close
                </t-button>

                &nbsp;

                <t-button :loadingWheel="isSaving" @click.native="initiateSave">
                    Save
                </t-button>
            </div>

        </div>


        <div class="w-full rounded mb-12">
            <editor v-model="sourceCode" @init="editorInit" lang="html" theme="twilight" width="100%" height="500"></editor>
        </div>


    </div>

</template>



<script>

export default {

    data: function () {
        return {
            templateId: null,
            fileName: null,
            isSaving: false,
            sourceCode: '<html></html>',
            mode: null,
        }
    },

    created() {

        this.mode = typeof this.$route.params.file === 'undefined' ? 'create' : 'edit'

        this.templateId = this.$route.params.id

        this.fetchContentAndLoadEditor()
    },

    components: { editor: require('vue2-ace-editor') },


    methods: {

        editorInit: function () {
            // require('brace/ext/language_tools') //language extension prerequsite...
            require('brace/mode/html')
            // require('brace/mode/javascript')    //language
            // require('brace/mode/less')
            require('brace/theme/twilight')
            // require('brace/snippets/javascript') //snippet
        },


        fetchContentAndLoadEditor: function () {

            if (typeof this.$route.params.id != 'undefined'
                && parseInt(this.$route.params.id) > 0
                && typeof this.$route.params.file != 'undefined') {

                this.fileName = this.$route.params.file

                util.ajax ('get',
                    '/api/templates/' + this.$route.params.id + '/get/' + this.$route.params.file,
                    {},
                    data => this.sourceCode = data
                )
            }
        },



        isValid: function () {

            if (!this.fileName) {
                util.notifyError('Name missing', 'Template file must have a name.')
                return false
            }

            return true
        },



        initiateSave: function () {

            if (this.isValid()) {

                this.isSaving = true

                util.ajax ('post', '/api/templates/' + this.$route.params.id + '/add',  {
                    name: this.fileName,
                    code: this.sourceCode
                }, this.postSaveProcessing)
            }
        },



        postSaveProcessing: function (successResponse) {

            this.isSaving = false

            if(this.mode === 'create')
            {
                this.mode = 'edit'

                this.$router.replace({ path: '/app/templates/' + this.templateId + '/get/' + this.fileName })
            }

            util.toast({
                icon: 'success',
                titleText: 'File Saved Successfully',
            })

        },

    }
}
</script>
