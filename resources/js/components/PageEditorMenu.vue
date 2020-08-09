<template>
    <div class="w-full px-6 border-b bg-gray-100">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <div class="flex justify-start items-center">
                <div
                    id="page-content-tab"
                    @click="$emit('input', 'content')"
                    class="px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer"
                    :class="
                        value === 'content'
                            ? 'text-blue-600 font-bold border-b-4 border-blue-500'
                            : ''
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 sm:hidden"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <span class="hidden sm:inline-block tracking-wider">Content</span>
                </div>
                <div
                    id="page-seo-tab"
                    @click="$emit('input', 'seo')"
                    class="px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer"
                    :class="
                        value === 'seo' ? 'text-blue-600 font-bold border-b-4 border-blue-500' : ''
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 sm:hidden"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path
                            d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"
                        ></path>
                    </svg>
                    <span class="hidden sm:inline-block tracking-wider">Seo</span>
                </div>
                <div
                    id="page-setting-tab"
                    @click="$emit('input', 'setting')"
                    class="px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer"
                    :class="
                        value === 'setting'
                            ? 'text-blue-600 font-bold border-b-4 border-blue-500'
                            : ''
                    "
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 sm:hidden"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="12" r="3"></circle>
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"
                        ></path>
                    </svg>
                    <span class="hidden sm:inline-block tracking-wider">Setting</span>
                </div>
                <div
                    id="page-gallery-tab"
                    @click="$emit('gallery')"
                    class="px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 sm:hidden"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    <span class="hidden sm:inline-block tracking-wider">Gallery</span>
                </div>
            </div>
            <t-button :loadingWheel="isSaving" @click.native="$emit('save')">
                Save
            </t-button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: String,
        },
        isSaving: {
            type: Boolean,
            default: false,
        },
    },
}
</script>
