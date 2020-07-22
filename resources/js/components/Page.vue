<template>
    <div class="w-full bg-white shadow border-t border-blue-300 rounded my-4">
        <div class="w-full relative">
            <t-toggle
                :id="'change-status-page-' + page.id"
                class="absolute top-0 mt-4 right-0 mr-8"
                v-model="page.status"
                true-value="Live"
                false-value="Draft"
                box-class="w-20 shadow-inner bg-gray-100 border rounded-l rounded-r cursor-pointer"
                true-class="h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm"
                false-class="h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm"
                :show-value="true"
                @input="changePageStatus(page, page.status)"
            >
            </t-toggle>

            <h3 class="px-6 pt-4 text-blue-400 text-sm">
                {{ page.category ? page.category.name : '' }}
            </h3>

            <h3
                :id="'show-page-' + page.id"
                class="px-6 pt-2 text-blue-800 font-semibold cursor-pointer"
                @click="openPageInEditor(page)"
            >
                {{ page.title }}
            </h3>

            <div class="px-6 py-4 text-sm text-gray-700">{{ page.summary }}</div>
        </div>

        <div class="px-6 py-2 bg-gray-100 text-xs flex justify-between items-center">
            <div class="mr-4 text-gray-700 flex items-center">
                <img :src="page.author.avatar" class="h-6 w-6 rounded-full mr-4" />
                {{ page.author.name }} updated {{ page.updated_ago }}.
                <span
                    class="ml-4 hover:underline text-blue-400 cursor-pointer"
                    @click="changeOwner"
                    v-if="canChangeOwner"
                >
                    Make me Author
                </span>
            </div>

            <div
                :id="'view-page-' + page.id"
                @click="openPageInNewWindow(page)"
                class="text-right text-normal text-gray-500 hover:text-blue-700 cursor-pointer"
            >
                # {{ page.id }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        page: {
            type: Object,
        },
    },

    data() {
        return {
            selected: null,
        }
    },

    computed: {
        canChangeOwner() {
            return (
                ['admin', 'author'].indexOf(this.$root.authUser.role) > -1 &&
                this.$root.authUser.id != this.page.author.id &&
                this.page.deleted_at === null
            )
        },
    },

    methods: {
        // open a specific page in editor
        openPageInEditor(page) {
            this.$router.push({ path: '/app/pages/' + page.id })
        },

        openPageInNewWindow(page) {
            window.open(page.url, '_blank')
        },

        // change the status (Draft / Live) of a specific page
        changePageStatus(page, status) {
            util.ajax(
                'put',
                '/api/pages/' + page.id + '/status',
                { status: status },
                (response) => {
                    page.status = status

                    util.toast({
                        icon: 'success',
                        titleText: 'Status Updated',
                        text: ' Page in ' + status + ' mode now.',
                    })
                }
            )
        },
        changeOwner() {
            util.ajax(
                'put',
                '/api/pages/' + this.page.id + '/owner',
                { user_id: this.$root.authUser.id },
                (response) => {
                    this.page.author = response.author

                    util.toast({
                        icon: 'success',
                        titleText: 'Owner Updated',
                        text: 'Page author is ' + response.author.name + ' now.',
                    })
                }
            )
        },
    },
}
</script>
