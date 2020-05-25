<template>

    <div class="w-full">



        <div class="rounded max-w-xl bg-white shadow rounded">

            <p class="text-sm px-6 py-4 border-b text-gray-700 uppercase">Software Update</p>

            <div class="p-6">

                <div class="-mt-2 pb-4 text-sm text-gray-700">
                    Automatically update your site to the latest version of Webtheory software.
                    Updating fixes any known bugs/issues and adds new feature enhancements.
                </div>

                <t-button :loadingWheel="isUpdating" textSize="normal" @click.native="updateSite">
                    Update Software
                </t-button>

            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            isUpdating: false,
        }
    },

    methods: {

        updateSite (commitId) {

            let p = this
            p.isUpdating = true

            window.axios.post('/api/settings/update/', {"commit_id": commitId})
            .then(response => {
                util.notifySuccess ('Success', response.data)
                p.isUpdating = false
            })
            .catch(error => {
                util.notifyError ('Error', error)
                p.isUpdating = false
            })
        }


    }
}
</script>