<template>
    <div id="tensor-editor" class="w-full te-typo"></div>

</template>

<script>

import EditorJS from '@editorjs/editorjs';

import Header from '@editorjs/header';
import List from '@editorjs/list';
import CodeTool from '@editorjs/code';
import InlineCode from '@editorjs/inline-code';
import Marker from '@editorjs/marker';
import Table from '@editorjs/table';
import ImageTool from '@editorjs/image';
import Embed from '@editorjs/embed';

export default {

    props: ['content'],
    data: function () {
        return {
            editor: null
        }
    },
    methods: {

        prepareStructuredDataAndNotify: function () {

            this.editor
            .save()
            .then((outputData) => {
                // console.log('Article data: ', outputData)

                this.$emit('data-prepare-success', outputData);

            }).catch((error) => {
                // console.log('Saving failed: ', error)

                this.$emit('data-prepare-error', error);

            });
        }
    },
    created: function () { 

        this.editor = new EditorJS ({

            holder: 'tensor-editor',
            data: this.content,

            tools: { 

                // allows you to insert a header block
                header: {
                    class: Header,
                    config: {
                        placeholder: 'Enter a sub-heading...'
                    },
                },

                // allows you to highlight inline texts
                marker: Marker,

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
                        rows: 1,
                        cols: 2,
                    },
                },

                // allows uploading image via the editor
                image: {
                    class: ImageTool,
                    config: {
                        endpoints: {
                            byFile: '/admin/media/uploadFile', // Backend file uploader endpoint
                            byUrl: '/admin/media/fetchUrl',    // Endpoint that provides uploading by Url
                        },
                        additionalRequestHeaders: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                        }
                    }
                },

                embed: {
                    class: Embed,
                    inlineToolbar: true,
                    config: {
                        services: {
                            youtube: true,
                            vimeo: true,
                            codepen: true
                        }
                    }
                }

            }
        });

    }
}

</script>


<style>
.image-tool__caption {
    min-height: 45px
}
</style>


