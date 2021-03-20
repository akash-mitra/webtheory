<template>
    <div class="bg-white shadow-lg relative overflow-hidden">
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
            <h3 class="text-lg font-bold py-1">
                <span class="truncate">{{ template.name }}</span>
            </h3>

            <div class="text-sm text-gray-700 py-2 h-20 overflow-hidden">
                {{ template.description }}
            </div>

            <div class="w-full flex items-center">
                <div class="w-1/2">
                                <span class="px-3 py-1 rounded-lg text-sm bg-gray-200 border"
                                >Version {{ template.version }}</span
                                >
                </div>
                <div class="w-1/2 flex justify-end">
                    <t-button
                        :id="'install-template-' + template.id"
                        :loadingWheel="isSaving"
                        color="blue"
                        @click.native="$emit('install')"
                    >
                        Install Now
                    </t-button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'AvailableTemplateTile',
    props: {
        isSaving: false,
        template: {}
    }
}
</script>
