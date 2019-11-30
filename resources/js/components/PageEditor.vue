<template>

    <div class="w-full">

        

        <div class="w-full px-6 border-b bg-white">

            <div class="mx-auto flex justify-between items-center" style="max-width: 650px">

                <div class="flex justify-start items-center">
                    <div class="px-6 py-4 text-blue-600 text-sm font-bold border-b-4 border-blue-500 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 sm:hidden"><path class="primary" d="M6 2h6v6c0 1.1.9 2 2 2h6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2zm2 11a1 1 0 0 0 0 2h8a1 1 0 0 0 0-2H8zm0 4a1 1 0 0 0 0 2h4a1 1 0 0 0 0-2H8z"/><polygon class="secondary" points="14 2 20 8 14 8"/></svg>
                        <span class="hidden sm:inline-block tracking-wider">Contents</span>
                    </div>
                    <div class="px-6 py-4 text-gray-800 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 sm:hidden"><path class="primary" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"/><path class="secondary" d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/></svg>
                        <span class="hidden sm:inline-block tracking-wider">Meta</span>
                    </div>
                    <div class="px-6 py-4 text-gray-800 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 sm:hidden"><path class="secondary" fill-rule="evenodd" d="M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                        <span class="hidden sm:inline-block tracking-wider">Settings</span>
                    </div>
                </div>
                <button @click="initiateSave" class="text-xs py-2 px-6 bg-blue-500 text-white rounded-lg shadow">Save</button>
            </div>

        </div>

        

        <div class="pt-10 w-full p-6 pb-24">

            <div class="mx-auto" style="max-width: 650px"> 
                <label v-show="title.length===0" class="uppercase text-xs tracking-wider text-gray-700 block pb-2">
                    Title
                </label>
                
                <textarea name="title" v-model="title" class="bg-transparent border-b-2 border-gray-400 h-24 outline-none text-blue-800 text-3xl tracking-wide w-full" placeholder="Title of your story"></textarea>
            </div>

            <div class="mt-12 mx-auto" style="max-width: 650px">
                <label v-show="intro.length===0" class="uppercase text-xs tracking-wider text-gray-700 block pb-2">
                    Intro
                </label>
                <textarea name="intro" v-model="intro" class="bg-transparent border-b-2 border-gray-400 h-24 outline-none text-gray-700 text-lg tracking-wide w-full" placeholder="Provide a 3/4 lines of introduction to your story..."></textarea>
            </div>

        </div>


        <div class="w-full p-2 bg-gray-100">

            

            <div class="max-w-4xl mx-auto bg-white -mt-16 shadow-xl px-6 pt-6">
                
                <div id="tensor-editor" class="mt-4 mx-auto text-gray-700 py-4 te-typo bg-white -mr-2"></div>  
            </div>


            
        </div>

    </div>

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

// temporarily use some sample contents for development, can be deleted later
import sampleContent from '../sampleContent.js'; 

export default {

    
    data: function () {
        return {
            editor: null,
            title: 'How to compose an article in WebTheory editor',
            intro: 'Describes various writing, editing and composing tools available under WebTheory Editor along with their usage',
            body: sampleContent,
            metakey: '',
            metadesc: '',
            category_id: 1
        }
    },
    methods: {

        initiateSave: function () {

            this.editor
            .save()
            .then((bodyJson) => {
                let p = this
                util.ajax ('post', '/api/pages', 
                    {
                        title: p.title,
                        summary: p.intro,
                        body_json: JSON.stringify(bodyJson),
                        metakey: p.metakey,
                        metadesc: p.metadesc,
                        category_id: p.category_id
                    }
                )

                
            }).catch((error) => {
                console.log('Saving failed: ', error)

                // this.$emit('data-prepare-error', error);

            });
        }
    },
    created: function () { 

        this.editor = new EditorJS ({

            holder: 'tensor-editor',
            data: this.body,

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
                            byFile: '/server/media/uploadFile', // Backend file uploader endpoint
                            byUrl: '/server/media/fetchUrl',    // Endpoint that provides uploading by Url
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

.primary {
    fill: #A5B3BB
}

</style>

<style lang="scss">
    @import '../../sass/typography.scss';
</style>


