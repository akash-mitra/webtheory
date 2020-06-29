<template>

    <div class="max-w-5xl mx-auto pb-12">

        <div class="px-6 my-6 w-full flex justify-between items-center">
            <h2 class="text-gray-600 text-2xl flex items-center">Settings</h2>

        </div>

        <div class="px-6 w-full flex justify-between items-center my-8 border-b">
            <div class="flex justify-start">

                <div @click="tab='site'" class="-ml-4 px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='site'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Site
                </div>

                <div @click="tab='login'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='login'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Login
                </div>

                <div @click="tab='notification'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='notification'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Notification
                </div>

                <div @click="tab='services'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='services'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    services
                </div>

                <div @click="tab='maintainance'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='maintainance'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    maintainance
                </div>

            </div>
        </div>


        <div v-if="tab=='site'">

            <SiteSettings></SiteSettings>

        </div>


        <div v-if="tab=='login'">

            <LoginSettings></LoginSettings>

        </div>


        <div v-if="tab=='notification'">

            <MailSettings></MailSettings>

        </div>

        <div v-if="tab=='services'">

            <SearchServiceSettings></SearchServiceSettings>

        </div>


        <div v-if="tab=='maintainance'">

            <UpdateSettings></UpdateSettings>

        </div>

    </div>
</template>

<script>

    import SiteSettings from './SiteSettings.vue'
    import LoginSettings from './LoginSettings.vue'
    import MailSettings from './MailSettings.vue'
    import UpdateSettings from './UpdateSettings.vue'
    import SearchServiceSettings from './SearchServiceSettings.vue'

    export default {

        components: {
            SiteSettings,
            LoginSettings,
            MailSettings,
            UpdateSettings,
            SearchServiceSettings,
        },

        data() {
            return {
                tab: 'services',
            }
        },
    }

</script>
