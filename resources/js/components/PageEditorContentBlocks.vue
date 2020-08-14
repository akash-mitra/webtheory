<template>
    <div>
        <div v-for="(content, index) in contents" class="w-full" :key="content.display_order">
            <div class="max-w-5xl bg-white mx-auto border-b relative">
                <div
                    class="absolute top-0 right-0 text-gray-600 text-xs px-4 py-1 flex justify-between"
                >
                    <svg
                        v-show="index > 0"
                        @click="$emit('up', index)"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 mx-1 cursor-pointer hover:text-blue-600"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <line x1="12" y1="19" x2="12" y2="5"></line>
                        <polyline points="5 12 12 5 19 12"></polyline>
                    </svg>
                    <svg
                        v-show="index < contents.length - 1"
                        @click="$emit('down', index)"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 mx-1 cursor-pointer hover:text-blue-600"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <polyline points="19 12 12 19 5 12"></polyline>
                    </svg>
                    <svg
                        @click="$emit('delete', index)"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 mx-1 cursor-pointer hover:text-red-600"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>

                <PageEditorRaw v-if="content.type === 'raw'" :content="content"></PageEditorRaw>

                <PageEditorJsPlus
                    v-if="content.type === 'editorjs'"
                    :content="content"
                    @change="
                        content.body_json = $event
                        content.changed = true
                    "
                    class="pt-4 border-l border-white hover-left-border"
                ></PageEditorJsPlus>
            </div>
        </div>

        <div class="w-full max-w-5xl mx-auto -mt-1c flex justify-end mb-10">
            <div
                class="px-3 py-2 bg-white rounded-lg rounded-t-none inline-block cursor-pointer text-blue-500 font-bold hover:text-blue-600"
                @click="showBlocks = !showBlocks"
            >
                + BLOCK
            </div>
        </div>

        <t-modal :show="showBlocks" @close="showBlocks = false" :show-footer="false">
            <template v-slot:header>
                <p class="text-xl text-gray-600 px-6 py-4">Select Content Block</p>
            </template>

            <div
                style="max-height: 300px;"
                class="p-4 overflow-y-auto border-t flex flex-wrap bg-gray-100"
            >
                <div v-for="bt in blockTypes" class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <div
                        class="bg-white rounded-lg shadow p-4 border cursor-pointer hover:bg-blue-100"
                        @click="
                            $emit('add', bt.type)
                            showBlocks = false
                        "
                    >
                        <div
                            class="w-full flex justify-center text-gray-500"
                            v-html="bt.icon"
                        ></div>
                        <div class="w-full flex justify-center font-bold text-blue-600 my-3">
                            {{ bt.header }}
                        </div>
                        <div class="w-full flex justify-center text-sm text-gray-800 text-center">
                            {{ bt.text }}
                        </div>
                    </div>
                </div>
            </div>
        </t-modal>
    </div>
</template>

<script>
import PageEditorRaw from './PageEditorRaw.vue'
import PageEditorJsPlus from './PageEditorJsPlus.vue'
export default {
    props: {
        contents: {
            type: Array,
        },
    },

    data() {
        return {
            showBlocks: false,
            blockTypes: [
                {
                    type: 'editorjs',
                    icon:
                        '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
                    header: 'Editor',
                    text: 'A simple and beautiful WYSIWYG Editor for regular use',
                },
                {
                    type: 'html',
                    icon:
                        '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>',
                    header: 'HTML',
                    text: 'Create your custom markup using raw HTML code.',
                },
                {
                    type: 'markdown',
                    icon:
                        '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>',
                    header: 'Markdown',
                    text: 'Create rich page in markdown with plain-text formatting',
                },
                {
                    type: 'gallery',
                    icon:
                        '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>',
                    header: 'Image Gallery',
                    text: 'Embed an image gallery with selected set of images',
                },
                {
                    type: 'tweet',
                    icon:
                        '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>',
                    header: 'Embed a Tweet',
                    text: 'Embed a specific tweet from Twitter directly in the page',
                },
                {
                    type: 'columns',
                    icon:
                        '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"></path></svg>',
                    header: 'Multi-Column',
                    text: 'Show contents side by side in multi-column layout',
                },
                {
                    type: 'note',
                    icon:
                        '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
                    header: 'Note Card',
                    text: 'A simple but beautiful WYSIWYG Editor',
                },
            ],
        }
    },

    components: {
        PageEditorRaw,
        PageEditorJsPlus,
    },
}
</script>
<style scoped>
.hover-left-border:hover {
    border-left: 1px solid lightblue;
}
.hover-left-border {
    box-sizing: border-box;
}
</style>
