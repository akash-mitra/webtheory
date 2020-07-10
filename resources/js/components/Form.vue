<template>
    <div class="w-full bg-white px-4 py-2 flex items-center justify-between">
        <div class="w-1/3 flex text-gray-800">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8 mt-2 flex-shrink-0 text-gray-400"
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
                        class="text-blue-600 text-xl"
                    >
                        {{ item.name }}
                    </router-link>
                </div>
                <div class="text-xs py-2">Created {{ item.created_ago }}</div>
            </div>
        </div>

        <div class="w-1/3 px-4">
            <t-toggle
                v-model="item.status"
                true-value="Live"
                false-value="Draft"
                box-class="w-16 shadow-inner bg-white border rounded-l rounded-r cursor-pointer"
                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                :show-value="true"
            >
            </t-toggle>
        </div>

        <div class="w-1/3 px-4">
            {{ responses }}
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

    data() {
        return {
            responses: 0,
        }
    },
}
</script>
