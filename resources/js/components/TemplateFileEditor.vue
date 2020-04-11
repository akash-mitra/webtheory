<template>

    <div class="max-w-5xl mx-auto">

        <div class="px-2 my-6 w-full flex justify-between items-baseline">
            <h2 class="text-gray-600 text-2xl flex items-center">{{ templateName }}</h2>
            <t-button :loadingWheel="isSaving" @click.native="initiateSave">
                    Save
            </t-button>
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
            templateName: this.$route.params.file,
            isSaving: false,
            sourceCode: '<html></html>',
            id: 0,
        }
    },

    created() {

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

                util.ajax ('get',
                    '/api/templates/' + this.$route.params.id + '/get/' + this.$route.params.file,
                    {},
                    data => this.sourceCode = data
                )
            }
        },



        isValid: function () {

            // if (!this.type) {
            //     util.notifyError('Template must have a type', 'Select any one type for this template, e.g. "Home" or "Single" etc.')
            //     return false
            // }

            return true
        },



        initiateSave: function () {

            if (this.isValid()) {

                this.isSaving = true

                util.ajax ('post', '/api/templates/' + this.$route.params.id + '/add',  {
                    name: this.$route.params.file,
                    code: this.sourceCode
                }, this.postSaveProcessing)
            }
        },



        postSaveProcessing: function (successResponse) {

            this.isSaving = false

            util.toast({
                icon: 'success',
                titleText: 'File Saved Successfully',
            })

        },

    }
}
</script>
