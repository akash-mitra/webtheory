<template>
    <div class="bg-white shadow-lg relative overflow-hidden">
        <div class="w-full flex justify-right absolute top-0 py-6 px-8">
            <svg
                v-if="template.active"
                class="fill-current w-6 h-6 p-1 bg-green-500 text-white text-xs rounded-full shadow-lg font-bold border border-white uppercase"
                viewBox="0 0 469 469"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"
                />
            </svg>
        </div>

        <div
            class="block w-full pattern-wall bg-blue-100"
            style="min-height: 180px; min-width: 150px;"
        >
            <img
                v-if="template.media_url !== null"
                :src="template.media_url"
                class="w-full h-48 object-cover"
            />
        </div>

        <div class="w-full p-6 flex flex-col justify-around">
            <h3 class="text-lg font-bold py-1 flex items-center justify-between">

                <a :href="'/app/templates/' + template.id"
                   class="text-gray-800 hover:text-blue-400">
                    {{ template.name }}
                </a>
                <a :href="'/api/templates/' + template.id + '/download'" class="w-8 h-8 text-blue-400">
                    <icon-download/>
                </a>
            </h3>

            <div class="text-sm text-gray-700 py-2 h-20 overflow-hidden">
                {{ template.description }}

            </div>

            <div class="w-full flex items-center pt-4 border-t">
                <div class="w-1/2">
                    <a
                        :id="'customize-template-' + template.id"
                        :href="'/app/templates/' + template.id"
                        class="text-blue-600 text-xs rounded py-2 pr-6"
                    >Customize</a
                    >
                </div>
                <div class="w-1/2 flex justify-end">
                    <t-button
                        v-if="!template.active"
                        :id="'activate-template-' + template.name"
                        :loadingWheel="isSaving"
                        color="blue"
                        @click.native="$emit('activate')"
                    >
                        Activate
                    </t-button>
                    <div v-else class="flex items-center text-green-500 py-1">
                        <svg
                            v-if="template.active"
                            class="mr-3 fill-current w-4 h-4 bg-transparent text-green-500 text-xs rounded-full font-bold border border-white uppercase"
                            viewBox="0 0 469 469"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"
                            />
                        </svg>
                        Current
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import IconDownload from '../icons/IconDownload.vue';
export default {
    name: 'InstalledTemplateTile',
    components: {IconDownload},
    props: {
        isSaving: false,
        template: {}
    }
}
</script>
