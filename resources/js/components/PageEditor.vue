<template>
    <div class="w-full bg-gray-200">
        <PageEditorMenu v-model="tab" @save="initiateSave"></PageEditorMenu>

        <div v-show="tab === 'content'" id="page-contents" class="w-full px-6">
            <div class="w-full max-w-5xl bg-white mx-auto border rounded-lg my-4 shadow">
                <div
                    class="w-full py-2 border-b bg-gray-100 cursor-pointer"
                    @click="hideHeader = !hideHeader"
                    :class="hideHeader ? 'rounded-lg' : 'rounded-t-lg'"
                >
                    <span v-show="!hideHeader" class="px-6 text-gray-800 text-xs uppercase"
                        >Header</span
                    >
                    <span v-show="hideHeader" class="px-6 text-gray-800 text-xs uppercase">{{
                        title
                    }}</span>
                </div>

                <div class="w-full mx-auto max-w-2xl mt-8" v-show="!hideHeader">
                    <label class="uppercase text-xs tracking-wider text-gray-700 block pb-2">
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
                        class="px-6 bg-gray-100 border rounded outline-none text-blue-800 text-3xl tracking-wide w-full placeholder-gray-700"
                        placeholder="Title of your story"
                        @input="resizeInput($event)"
                    ></textarea>

                    <t-error-message :errors="errors" field="title"></t-error-message>
                </div>

                <div class="w-full mx-auto max-w-2xl mt-8" v-show="!hideHeader">
                    <div class="uppercase text-xs tracking-wider text-gray-700 block pb-2">
                        Blog Image
                    </div>

                    <div class="mx-auto rounded max-w-2xl" v-show="!hideHeader">
                        <PhotoPicker
                            id="pageImage"
                            v-model="media"
                            image-classes="w-full"
                            container-classes="border rounded w-full bg-gray-100 flex items-center cursor-pointer"
                        ></PhotoPicker>
                    </div>
                </div>

                <div class="mt-12 mx-auto max-w-2xl pb-10" v-show="!hideHeader">
                    <label class="uppercase text-xs tracking-wider text-gray-700 block pb-2">
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
                        class="px-6 bg-gray-100 border rounded outline-none text-gray-700 text-lg tracking-wide w-full placeholder-gray-700"
                        placeholder="Provide a 3/4 lines of introduction to your story..."
                        @input="resizeInput($event)"
                        @focus="resizeInput($event)"
                    ></textarea>

                    <t-error-message :errors="errors" field="summary"></t-error-message>
                </div>
            </div>

            <div class="w-full max-w-5xl bg-white mx-auto border rounded-lg my-4 shadow">
                <div
                    class="w-full px-6 py-2 border-b bg-gray-100 text-gray-800 text-xs uppercase rounded-t-lg"
                >
                    Contents
                </div>
                <PageEditorContentBlocks
                    :contents="contents"
                    @add="addContentBlock"
                    @delete="removeContentBlock"
                    @down="downContentBlock"
                    @up="upContentBlock"
                ></PageEditorContentBlocks>
            </div>
        </div>

        <div
            v-show="tab === 'seo'"
            id="page-seo"
            class="w-full max-w-5xl mx-auto px-4 xl:px-0 pb-20"
        >
            <PageEditorSeoOrganize v-model="category_id"></PageEditorSeoOrganize>

            <PageEditorSeoMetaDesc
                v-model="metadesc"
                :intro="intro"
                :title="title"
            ></PageEditorSeoMetaDesc>
        </div>

        <div
            v-show="tab === 'setting'"
            id="page-setting"
            class="w-full max-w-4xl mx-auto px-4 xl:px-0 pb-20"
        ></div>
    </div>
</template>

<script>
import PageEditorContent from './PageEditorContent.vue'
import PageEditorSeoMetaDesc from './PageEditorSeoMetaDesc.vue'
import PageEditorSeoOrganize from './PageEditorSeoOrganize.vue'
import PageEditorSetting from './PageEditorSetting.vue'
import PageEditorGallery from './PageEditorGallery.vue'
import PageEditorMenu from './PageEditorMenu.vue'
import PageEditorContentBlocks from './PageEditorContentBlocks.vue'
import PhotoPicker from './PhotoPicker.vue'

export default {
    components: {
        PageEditorContent,
        PageEditorSeoMetaDesc,
        PageEditorSeoOrganize,
        PageEditorSetting,
        PageEditorGallery,
        PageEditorMenu,
        PageEditorContentBlocks,

        PhotoPicker,
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
            hideHeader: false,
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
        if (this.isNewPage()) {
            this.addContentBlock('editorjs')
        } else {
            this.title = 'Loading...'
            this.intro = 'Loading...'
            util.ajax('get', '/api/pages/' + this.$route.params.id, {}, (data) => {
                this.id = data.id
                this.title = data.title
                this.intro = data.summary
                this.metakey = data.metakey
                this.metadesc = data.metadesc
                this.category_id = data.category_id
                this.status = data.status
                this.media = data.media

                // enrich incoming data with temporary frontend_id
                data.contents.map((content) => {
                    content.frontend_id = content.id
                })
                this.contents = data.contents

                // pre-calculate the max display order
                this.maxDisplayOrder = 0
                for (let i = 0; i < this.contents.length; i++) {
                    let m = this.contents[i].display_order
                    if (m > this.maxDisplayOrder) {
                        this.maxDisplayOrder = m
                    }
                }

                // hide the header
                this.hideHeader = true
            })
        }

        // this.timer = window.setInterval(this.autoSave, this.autoSaveFreqSeconds * 1000)
    }, // end of created

    mounted() {
        window.document.addEventListener('keydown', this.keyboardHooks)
    },
    beforeDestroy() {
        window.document.removeEventListener('keydown', this.keyboardHooks)
    },

    methods: {
        isNewPage() {
            return typeof this.$route.params.id === 'undefined'
        },

        isJustCreated() {
            return this.id === 0
        },

        addContentBlock(type) {
            let underDev = ['markdown', 'gallery', 'tweet', 'columns', 'note']
            if (underDev.indexOf(type) > -1) {
                alert('This feature is not part of beta release yet')
                return
            }

            this.contents.push({
                // id: Id is only assigned after content is saved.
                // page_id: Page Id is only assigned after content is saved.
                type: type,
                body_html: '',
                body_json: { blocks: [] },
                display_order: this.maxDisplayOrder + 1,
                changed: true,
                frontend_id: new Date().getTime(),
            })
            this.maxDisplayOrder++
        },

        removeContentBlock(index) {
            util.confirm(
                'Delete this content block?',
                'This will permanently delete the block immediately',
                () => {
                    let block = this.contents[index]
                    if (block.hasOwnProperty('id') && parseInt(block.id) > 0) {
                        util.ajax('delete', '/api/pagecontent/' + block.id, {}, (response) => {
                            console.log(response)
                            this.contents.splice(index, 1)
                        })
                    } else {
                        this.contents.splice(index, 1)
                    }
                }
            )
        },

        downContentBlock(index) {
            let nextBlock = this.contents[index + 1]
            let block = this.contents.splice(index, 1)[0]

            this.swapDisplayOrder(block, nextBlock)

            block['changed'] = true
            nextBlock['changed'] = true

            this.contents.splice(index + 1, 0, block)
        },

        upContentBlock(index) {
            let prevBlock = this.contents[index - 1]
            let block = this.contents.splice(index, 1)[0]

            this.swapDisplayOrder(block, prevBlock)

            block['changed'] = true
            prevBlock['changed'] = true

            this.contents.splice(index - 1, 0, block)
        },

        swapDisplayOrder(first, second) {
            let t = first.display_order
            first.display_order = second.display_order
            second.display_order = t
        },

        isValid(showError) {
            if (typeof showError === 'undefined') showError = false

            if (!this.title) {
                showError &&
                    util.notifyError(
                        'Page has no title',
                        'Provide a title to save this page',
                        () => {
                            this.$refs.title.focus()
                        }
                    )

                return false
            }

            if (this.title.length >= 100) {
                showError &&
                    util.notifyError(
                        'Page title too long!',
                        'Keep page title within maximum 100 characters.',
                        () => {
                            this.$refs.title.focus()
                        }
                    )
                return false
            }

            if (!this.intro) {
                showError &&
                    util.notifyError(
                        'Provide an Introduction',
                        'Write a few lines of intro for this page before saving.',
                        () => {
                            this.$refs.intro.focus()
                        }
                    )
                return false
            }

            if (this.intro.length >= 1048) {
                showError &&
                    util.notifyError(
                        'Intro too long',
                        'Keep page intro within about 1000 characters',
                        () => {
                            this.$refs.intro.focus()
                        }
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
            let id = parseInt(successResponse.id)

            if (isNaN(id)) {
                util.notifyError(
                    "Ouch! Couldn't save that.",
                    'Please refresh the page and try again'
                )
                return
            }

            if (this.isJustCreated()) {
                this.id = id
                // change the address bar URL to en edit page url
                this.$router.replace({ path: '/app/pages/' + id })
            }

            this.contents.map((content) => {
                content.changed = false
                content.page_id = id

                content.id = this.getIdByDisplayOrder(successResponse, content.display_order)
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

        getIdByDisplayOrder(response, display_order) {
            let content = response.contents.filter((content) => {
                return content.display_order === display_order
            })
            return content[0].id
        },

        keyboardHooks(e) {
            if (e.ctrlKey || e.metaKey) {
                let code = e.which || e.keyCode

                // handle save with ctrl+s
                if (code === 83) {
                    e.preventDefault()
                    this.initiateSave()
                }
            }
        },
    }, // end of methods
}
</script>
<style scoped>
/* for autosizing the textareas */
.autoheight {
    resize: none;
    overflow: hidden;
    min-height: 2em;
    max-height: 10em;
}

.bg-pattern {
    background-color: #cbd5e0;
    background-image: url("data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23a0aec0' fill-opacity='0.4' fill-rule='evenodd'%3E%3Cpath d='M5 0h1L0 6V5zM6 5v1H5z'/%3E%3C/g%3E%3C/svg%3E");
}
</style>
