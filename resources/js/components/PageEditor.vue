<template>
    <div class="w-full bg-gray-200">
        <PageEditorMenu v-model="tab" @save="initiateSave"></PageEditorMenu>

        <div v-show="tab === 'content'" id="page-contents" class="w-full px-6">
            <div class="py-10 w-full max-w-5xl bg-white mx-auto border-b">
                <div class="w-full mx-auto max-w-2xl">
                    <label class="px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2">
                        Title
                        <span
                            v-if="!!title"
                            class="bg-gray-100 rounded-lg py-1 px-2 ml-4"
                            :class="title.length > 100 ? 'text-red-400' : 'text-gray-600'"
                        >
                            {{ title.length }}</span
                        >
                    </label>

                    <textarea
                        name="title"
                        v-model="title"
                        ref="title"
                        class="autoheight h-8 px-6 bg-transparent border-b-2 border-gray-400 outline-none text-blue-800 text-3xl tracking-wide w-full placeholder-gray-700"
                        placeholder="Title of your story"
                        @input="resizeInput($event)"
                    ></textarea>

                    <t-error-message :errors="errors" field="title"></t-error-message>
                </div>

                <div class="mt-12 mx-auto max-w-2xl">
                    <label class="px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2">
                        Intro
                        <span
                            v-if="!!intro"
                            class="bg-gray-100 rounded-lg py-1 px-2 ml-4"
                            :class="intro.length > 1048 ? 'text-red-400' : 'text-gray-600'"
                        >
                            {{ intro.length }}
                        </span>
                    </label>

                    <textarea
                        name="intro"
                        v-model="intro"
                        ref="intro"
                        class="autoheight h-auto px-6 bg-transparent outline-none text-gray-700 text-lg tracking-wide w-full placeholder-gray-700"
                        placeholder="Provide a 3/4 lines of introduction to your story..."
                        @input="resizeInput($event)"
                        @focus="resizeInput($event)"
                    ></textarea>

                    <t-error-message :errors="errors" field="summary"></t-error-message>
                </div>
            </div>

            <PageEditorContentBlocks
                :contents="contents"
                @add="addContentBlock"
                @delete="removeContentBlock"
                @down="downContentBlock"
                @up="upContentBlock"
            ></PageEditorContentBlocks>
        </div>

        <div
            v-show="tab === 'seo'"
            id="page-seo"
            class="w-full max-w-4xl mx-auto px-4 xl:px-0 pb-20"
        ></div>

        <div
            v-show="tab === 'setting'"
            id="page-setting"
            class="w-full max-w-4xl mx-auto px-4 xl:px-0 pb-20"
        ></div>
    </div>
</template>

<script>
import PageEditorContent from './PageEditorContent.vue'
import PageEditorSeo from './PageEditorSeo.vue'
import PageEditorSetting from './PageEditorSetting.vue'
import PageEditorGallery from './PageEditorGallery.vue'
import PageEditorMenu from './PageEditorMenu.vue'
import PageEditorContentBlocks from './PageEditorContentBlocks.vue'

export default {
    components: {
        PageEditorContent,
        PageEditorSeo,
        PageEditorSetting,
        PageEditorGallery,
        PageEditorMenu,
        PageEditorContentBlocks,
    },

    data() {
        return {
            id: 0,
            title: null,
            intro: null,
            metakey: null,
            metadesc: null,
            category_id: 1,
            media: null,
            status: 'Draft',
            contents: [],

            tab: 'content',

            isSaving: false,
            errors: {
                title: [],
                summary: [],
                metadesc: [],
                metakey: [],
            },
            maxDisplayOrder: 1,
        }
    },

    created() {
        util.ajax('get', '/api/pages/' + this.$route.params.id, {}, (data) => {
            this.id = data.id
            this.title = data.title
            this.intro = data.summary
            this.metakey = data.metakey
            this.metadesc = data.metadesc
            this.category_id = data.category_id
            this.status = data.status
            this.media = data.media
            this.contents = data.contents

            this.maxDisplayOrder = 0
            for (let i = 0; i < this.contents.length; i++) {
                let m = this.contents[i].display_order
                if (m > this.maxDisplayOrder) {
                    this.maxDisplayOrder = m
                }
            }
        })

        // this.timer = window.setInterval(this.autoSave, this.autoSaveFreqSeconds * 1000)
    }, // end of created

    methods: {
        isNewPage() {
            return typeof this.$route.params.id === 'undefined'
        },

        isJustCreated() {
            return this.id === 0
        },

        addContentBlock(type) {
            this.contents.push({
                type: type,
                body_html: '',
                body_json: { blocks: [] },
                display_order: this.maxDisplayOrder + 1,
                changed: true,
            })
            this.maxDisplayOrder++
        },

        removeContentBlock(index) {
            this.contents.splice(index, 1)
        },

        downContentBlock(index) {
            this.contents.splice(index + 1, 0, this.contents.splice(index, 1)[0])
        },

        upContentBlock(index) {
            this.contents.splice(index - 1, 0, this.contents.splice(index, 1)[0])
        },

        isValid(showError) {
            if (typeof showError === 'undefined') showError = false

            if (!this.title) {
                showError &&
                    util.notifyError('Page has no title', 'Provide a title to save this page')
                return false
            }

            if (this.title.length >= 100) {
                showError &&
                    util.notifyError(
                        'Page title too long!',
                        'Keep page title within maximum 100 characters.'
                    )
                return false
            }

            if (!this.intro) {
                showError &&
                    util.notifyError(
                        'Provide an Introduction',
                        'Write a few lines of intro for this page before saving.'
                    )
                return false
            }

            if (this.intro.length >= 1048) {
                showError &&
                    util.notifyError(
                        'Intro too long',
                        'Keep page intro within about 1000 characters'
                    )
                return false
            }

            return true
        },

        getSaveUrl() {
            if (this.id > 0) return '/api/pages/' + this.id
            else return '/api/pages'
        },

        getSaveMethod() {
            if (this.id > 0) return 'put'
            else return 'post'
        },

        autoSave() {
            //this.isValid(false) && this.initiateSave()
        },

        initiateSave() {
            if (this.isValid(true)) {
                this.errors = {}

                this.isSaving = true

                util.ajax(
                    this.getSaveMethod(),
                    this.getSaveUrl(),
                    {
                        id: this.id,
                        title: this.title,
                        summary: this.intro,
                        contents: this.contents,
                        metakey: this.metakey,
                        metadesc: this.metadesc,
                        category_id: this.category_id,
                        media_id: !!this.media ? this.media.id : null,
                        status: this.status,
                        editor: this.EDITOR_IDENTITY,
                    },
                    this.onPostSuccess,
                    this.on4xxError,
                    this.on5xxError
                )
            }
        },

        onPostSuccess(successResponse) {
            if (this.isJustCreated()) {
                // assign new Id
                let id = parseInt(successResponse.id)
                this.id = id

                // change the address bar URL to en edit page url
                this.$router.replace({ path: '/app/pages/' + id })
            }

            this.contents.map((content) => {
                content.changed = false
            })

            this.isSaving = false

            util.toast({
                icon: 'success',
                titleText: 'Page Contents are Saved.',
            })
        }, // end of onPostSuccess

        on4xxError(status, data) {
            this.isSaving = false

            util.notifyError("Ouch! Couldn't save that...", data.message)

            if (status === 422) {
                this.errors = data.errors
            }
        },

        on5xxError(status, data) {
            this.isSaving = false

            util.notifyError('Failed to save the page to server.', data.message)

            console.log(data)
        },

        resizeInput(e) {
            e.target.style.height = 'auto'
            e.target.style.height = e.target.scrollHeight + 'px'
        },
    }, // end of methods
}
</script>
