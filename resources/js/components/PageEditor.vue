<template>
    <div class="w-full bg-white">
        <PageEditorMenu v-model="tab"></PageEditorMenu>

        <div v-show="tab === 'content'" id="page-contents" class="w-full">
            <div class="pt-10 w-full">
                <div class="w-full mx-auto max-w-5xl">
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

                <div class="mt-12 mx-auto max-w-5xl">
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
                        class="border autoheight h-auto px-6 bg-transparent outline-none text-gray-700 text-lg tracking-wide w-full placeholder-gray-700"
                        placeholder="Provide a 3/4 lines of introduction to your story..."
                        @input="resizeInput($event)"
                        @focus="resizeInput($event)"
                    ></textarea>

                    <t-error-message :errors="errors" field="summary"></t-error-message>
                </div>
            </div>
            <div class="max-w-5xl mx-auto mt-12 border">
                <div v-for="content in contents" class="w-full mt-12">
                    <PageEditorRaw v-if="content.type === 'raw'" :content="content"></PageEditorRaw>
                    <PageEditorJs
                        v-if="content.type === 'editorjs'"
                        :data="JSON.parse(content.body_json)"
                        :content-id="content.id"
                        @change="contentChange"
                    ></PageEditorJs>
                </div>
            </div>
            <div class="max-w-5xl mx-auto mt-12 border flex items-center justify-between">
                <span class="px-4 py-2 bg-blue-500 text-white rounded" @click="addEditor"
                    >Add Content</span
                >
                <div class="inline-block relative w-64">
                    <select
                        class="block appearance-none w-full bg-gray-100 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg leading-tight focus:outline-none focus:shadow-outline border"
                        v-model="currentEditorType"
                    >
                        <option v-for="option in editorTypes" :value="option.value">{{
                            option.text
                        }}</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                    >
                        <svg
                            class="fill-current h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
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
import PageEditorRaw from './PageEditorRaw.vue'
import PageEditorJs from './PageEditorJs.vue'

export default {
    components: {
        PageEditorContent,
        PageEditorSeo,
        PageEditorSetting,
        PageEditorGallery,
        PageEditorMenu,
        PageEditorRaw,
        PageEditorJs,
    },

    data: function () {
        return {
            id: 0,
            title: null,
            intro: null,
            metakey: null,
            metadesc: null,
            category_id: 1,
            media: null,
            status: 'Draft',

            contents: [{ type: 'raw', body_json: '', body_html: '', display_order: 1 }],
            editors: [],

            tab: 'content',

            isSaving: false,
            errors: {
                title: [],
                summary: [],
                metadesc: [],
                metakey: [],
            },

            EDITOR_IDENTITY: 'editorjs',
            editorTypes: [{ value: 'raw', text: 'Raw HTML editor' }],
            currentEditorType: 'raw',
            currentDisplayOrder: 1,
            showGallery: false,

            timer: null,
            autoSaveFreqSeconds: 60,
        }
    },

    created: function () {
        util.ajax('get', '/api/pages/' + this.$route.params.id, {}, (data) => {
            this.id = data.id
            this.title = data.title
            this.intro = data.summary
            this.metakey = data.metakey
            this.metadesc = data.metadesc
            this.category_id = data.category_id
            this.status = data.status
            this.media = data.media
            this.contents = data.content
            // p.editor = p.loadEditorTool()
        })

        // this.timer = window.setInterval(this.autoSave, this.autoSaveFreqSeconds * 1000)
    }, // end of created

    methods: {
        isNewPage() {
            return typeof this.$route.params.id === 'undefined'
        },

        contentChange(content) {
            console.log(content)
            // this.data
        },

        addEditor() {
            this.contents.push({
                type: this.currentEditorType,
                body_json: '',
                body_html: '',
                display_order: this.currentDisplayOrder + 1,
            })
            this.currentDisplayOrder++
        },
    }, // end of methods
}
</script>
