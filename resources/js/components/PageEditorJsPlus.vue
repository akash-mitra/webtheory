<template>
    <div :id="holderId"></div>
</template>

<script>
import EditorJS from '@editorjs/editorjs'
import Header from '@editorjs/header'
import List from '@editorjs/list'
import CodeTool from '@editorjs/code'
import InlineCode from '@editorjs/inline-code'
import Marker from '@editorjs/marker'
import Table from '@saurav.mitra/editor-table'
import ImageTool from '@editorjs/image'
import Embed from '@editorjs/embed'

export default {
    props: {
        holderId: {
            type: String,
            default: () => Math.random().toString().substr(2),
            required: false,
        },
        content: {
            type: Object,
            default: () => {
                return { blocks: [] }
            },
            required: false,
        },
    },
    data() {
        return {
            editor: null,

            tools: {
                // allows you to insert a header block
                header: {
                    class: Header,
                    inlineToolbar: true,
                    config: {
                        placeholder: 'Enter a sub-heading...',
                        levels: [2, 3, 4],
                    },
                },

                // allows you to highlight inline texts
                marker: Marker,

                // imageBrowser: ImageBrowser,

                // allows you to add a list
                list: {
                    class: List,
                    inlineToolbar: true,
                },

                // allows you to embed code
                code: CodeTool,

                inlineCode: InlineCode,

                // allows you to add table in the text
                table: {
                    class: Table,
                    config: {
                        rows: 2,
                        cols: 2,
                    },
                },

                // allows uploading image via the editor
                image: {
                    class: ImageTool,
                    config: {
                        endpoints: {
                            byFile: '/api/media', // Backend file uploader endpoint
                            byUrl: '/api/media/fetchUrl', // Endpoint that provides uploading by Url
                        },
                        additionalRequestHeaders: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content,
                        },
                    },
                },

                embed: {
                    class: Embed,
                    inlineToolbar: true,
                    config: {
                        services: {
                            youtube: true,
                            vimeo: true,
                            codepen: true,
                        },
                    },
                },
            }, // end of tools
            i18n: null,
        }
    },
    mounted() {
        this.initEditor()
    },
    beforeDestroy() {
        if (this.editor) {
            this.editor.destroy()
        }

        //console.log('dying', this.holderId, this.content.id)
    },

    methods: {
        initEditor() {
            // console.log('initialising editor for content ', this.holderId, this.content.id)
            if (!this.editor) {
                this.editor = new EditorJS({
                    holder: this.holderId,
                    autofocus: false,
                    placeholder: 'Click here and start writing...',
                    minHeight: 20,
                    data: this.content.body_json,
                    tools: this.tools,

                    onChange: async () => {
                        const contents = await this.editor.save()
                        // console.log(contents)
                        this.$emit('change', contents)
                    },
                })

                //this.$emit('init', { content: this.content, instance: this.editor })
            }
        },
    },
}
</script>

<style>
/**
     * Background color for the icons of "content", "meta", "seetings"
     * during the mobile responsive mode
     */
.bg-icon-primary {
    fill: #a5b3bb;
}

div.ce-paragraph {
    /*
            top and bottom padding must be equal to
            ensure correct positioning of "+"
            sign on left margin
        */
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    padding-left: 0.5rem;
    padding-right: 0.5rem;

    font-size: 1rem;
    line-height: 1.625;
}

h2.ce-header,
h3.ce-header,
h4.ce-header {
    padding-top: 1rem;
    padding-bottom: 0.25rem;
    margin-bottom: 0;
    margin-top: 0;
    font-family: Georgia, Cambria, 'Times New Roman', Times, serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

h2.ce-header {
    font-size: 1.875rem;
    line-height: 1.25;
    font-weight: 600;
    padding-bottom: 1rem;
    padding-top: 1rem;
}

h3.ce-header {
    font-size: 1.875rem;
    line-height: 1.35;
}

h4.ce-header {
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1.375;
    letter-spacing: 0.025em;
    padding-bottom: 0.25rem;
}

li.cdx-list__item {
    padding: 0.3rem 0 0.3rem 0.5rem;
    line-height: 1.625;
}

/**
     * IMAGE BORDER Styles.
     *
     * Disable the original 1px border that comes with editorjs.
     * Create a new 1rem border with shadow.
     */
.image-tool--withBorder div.image-tool__image {
    border-style: none;
}

.image-tool--withBorder img {
    /* equivalent to border p-4 shadow; */

    border: 1px solid #ccc;
    padding: 1rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

/**
     * IMAGE STRETCHED Styles.
     *
     * The image should stretch 100% of the container.
     */
.ce-block--stretched,
.ce-block--stretched img {
    width: 100%;
}

/* On screens that are 768px or more, set the padding */
@media screen and (min-width: 768px) {
    .ce-block--stretched {
        padding-right: 6rem;
        padding-left: 6rem;
    }
}

/**
     * IMAGE BACKGROUND
     *
     * Following css will reprogram the editorjs background
     * to work more like a image centering tool.
     */
.image-tool--withBackground div.image-tool__image {
    /* bg-white p-0; */
    background-color: #fff;
    padding: 0;
}

.image-tool--withBackground img.image-tool__image-picture {
    max-width: 100%;
}

/**
     * IMAGE CAPTION BOX
     *
     * Design for the caption box below image.
     */
.image-tool__caption {
    /* equivalent to bg-gray-100 rounded p-2 shadow-inner border */
    background-color: #f7fafc;
    border-radius: 0.25rem;
    padding: 0.5rem;
    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
    border-width: 1px;
}

/* Right Side Settings Menu
     *
     * Settings menu width.
     */
.ce-settings {
    min-width: 120px;
}

/**
     * CODE BOX
     * Make sure that the code box height is not too high by default
     * Set the height to 100px.
     */
.ce-code__textarea {
    height: 100px;
    min-height: 60px;
}
</style>
