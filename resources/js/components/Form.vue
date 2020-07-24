<template>
    <div class="w-full bg-white px-4 md:flex justify-between">
        <div class="w-full md:w-1/3 flex text-gray-500">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 mt-2 flex-shrink-0"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path
                    d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"
                ></path>
                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
            </svg>
            <div class="px-4">
                <div>
                    <router-link
                        :to="{ name: 'forms.edit', params: { id: item.id } }"
                        class="text-blue-500 cursor-pointer"
                    >
                        {{ item.name }}
                    </router-link>
                </div>
                <div class="text-xs text-gray-800 pt-1">Created {{ item.created_ago }}</div>
            </div>
        </div>

        <div class="w-full md:w-1/3 md:px-4 mt-4 md:mt-0">
            {{ item.status }}
        </div>

        <div class="md:px-4 mt-4 md:mt-0 flex-grow">
            <a
                :href="'forms/' + item.id + '/responses/download'"
                class="text-blue-500 py-2 rounded-lg cursor-pointer ml-1 inline-flex items-center"
            >
                <svg
                    class="w-4 h-4 mr-3"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Responses
            </a>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        item: {
            type: Object,
        },
    },
}
</script>
