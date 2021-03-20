<template>

    <div class="w-full sm:flex my-4 text-gray-800 bg-white rounded shadow p-8">

        <div v-if="asset.type === 'document'"
             class="w-full lg:w-1/4 sm:w-64 sm:h-64 flex items-center justify-center bg-gray-100 rounded shadow-inner text-gray-400">
            <div class="h-32 w-32">
                <icon-file-text/>
            </div>
        </div>

        <div v-else-if="asset.type === 'audio'"
             class="w-full lg:w-1/4 sm:w-64 sm:h-64 flex items-center justify-center bg-gray-100 rounded shadow-inner text-gray-400">
            <div class="h-32 w-32">
                <icon-speaker/>
            </div>
        </div>

        <div v-else-if="asset.type === 'video'"
             class="w-full lg:w-1/4 sm:w-64 sm:h-64 flex items-center justify-center bg-gray-100 rounded shadow-inner text-gray-400">
            <div class="h-32 w-32">
                <icon-video/>
            </div>
        </div>

        <div v-else-if="asset.type === 'program'"
             class="w-full lg:w-1/4 sm:w-64 sm:h-64 flex items-center justify-center bg-gray-100 rounded shadow-inner text-gray-400">
            <div class="h-32 w-32">
                <icon-cpu/>
            </div>
        </div>

        <div v-else-if="asset.type === 'internet'"
             class="w-full lg:w-1/4 sm:w-64 sm:h-64 flex items-center justify-center bg-gray-100 rounded shadow-inner text-gray-400">
            <div class="h-32 w-32">
                <icon-globe/>
            </div>
        </div>

        <div v-else-if="asset.type === 'compressed'"
             class="w-full lg:w-1/4 sm:w-64 sm:h-64 flex items-center justify-center bg-gray-100 rounded shadow-inner text-gray-400">
            <div class="h-32 w-32">
                <icon-archive/>
            </div>
        </div>

        <img v-else-if="asset.type === 'image'" :src="asset.url" alt=""
             class="w-full lg:w-1/4 sm:w-64 sm:h-64 object-cover rounded"/>

        <div v-else
             class="w-full lg:w-1/4 sm:w-64 sm:h-64 flex items-center justify-center bg-gray-100 rounded shadow-inner text-gray-400">
            <div class="h-32 w-32">
                <icon-file/>
            </div>
        </div>


        <div class="w-full lg:w-3/4 mt-6 sm:mt-0 overflow-hidden">
            <div class="sm:px-8 flex justify-between">
                <h3 class="flex-auto text-xl font-semibold overflow-hidden truncate">{{ fileName }}</h3>
                <span class="px-2 py-1 bg-gray-100 text-sm rounded">{{
                        asset.type.charAt(0).toUpperCase() + asset.type.slice(1)
                    }}</span>
            </div>
            <div class="sm:px-8 w-full flex-none text-xs font-medium text-gray-500 mt-2">
                <table class="w-full mt-2 table-auto">
                    <tr v-for="(pk, pv) in fileFields" class="border-b">
                        <td class="p-2 uppercase font-semibold text-gray-600 whitespace-no-wrap">
                            {{ pk.toUpperCase() }}
                        </td>
                        <td class="p-2 font-mono">{{ asset[pv] }}</td>
                    </tr>
                </table>
            </div>
            <div class="sm:px-8 flex justify-between mt-8 text-sm font-medium">
                <div class="flex items-center">
                    <a :href="asset.url" class="px-4 py-1 rounded-md bg-black text-white" target="_blank">Open</a>
                    <a :href="asset.url" class="ml-4 px-4 py-1 rounded-md border border-gray-300" download>Download</a>
                </div>
                <button class="px-4 py-1 rounded-md text-red-400 hover:bg-red-500 hover:text-white" @click="destroy">
                    Delete
                </button>
            </div>
        </div>

    </div>

</template>

<script>
import IconFileText from "./icons/IconFileText";
import IconSpeaker from "./icons/IconSpeaker";
import IconVideo from "./icons/IconVideo";
import IconCpu from "./icons/IconCpu";
import IconGlobe from "./icons/IconGlobe";
import IconArchive from "./icons/IconArchive";
import IconFile from "./icons/IconFile";

export default {
    name: "LibraryItem",
    components: {IconFile, IconArchive, IconGlobe, IconCpu, IconVideo, IconSpeaker, IconFileText},
    props: ['asset'],
    data() {
        return {
            fileFields: {
                url: 'url',
                size: 'File Size (KB)',
                storage: 'Storage Type',
                created_ago: 'Created',

            },
        }
    },
    computed: {
        fileName() {
            return util.initCap(this.asset.name.split(".")[0])
        }
    },
    methods: {
        destroy() {
            util.confirm("Delete file?", "This will be permanently removed.", () => {
                this.$emit('deleted', this.asset)
            });
        }
    }
}
</script>
