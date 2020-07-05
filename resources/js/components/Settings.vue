<template>

    <div class="max-w-5xl mx-auto pb-12">

        <div class="px-6 my-6 w-full flex justify-between items-center">

            <h2 class="text-indigo-600 text-2xl flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                Settings
            </h2>

        </div>

        <div class="px-6 w-full flex justify-between items-center my-8 border-b">
            <div class="flex justify-start">

                <div id="settings-site-tab" @click="tab='site'" class="-ml-4 px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='site'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Site
                </div>

                <div id="settings-login-tab" @click="tab='login'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='login'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Login
                </div>

                <div id="settings-notification-tab" @click="tab='notification'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='notification'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Notification
                </div>

                <div id="settings-services-tab" @click="tab='services'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='services'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    services
                </div>

                <div id="settings-maintainance-tab" @click="tab='maintainance'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='maintainance'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
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

            <div class="w-full flex px-6">
                <div class="text-right text-gray-700 text-sm max-w-xs bg-gray-1001">

                    <div class='w-full pr-8 py-4 cursor-pointer' @click="subtab='search'" :class="subtab==='search'? 'text-indigo-500 font-bold':''">
                        Full-text Search
                    </div>

                    <div class='w-full pr-8 py-4 cursor-pointer' @click="subtab='share'" :class="subtab==='share'? 'text-indigo-500 font-bold':''">
                        Social Share
                    </div>

                </div>
                <div class="flex-grow">
                    <div class='w-full'>
                        <SearchServiceSettings v-if="subtab==='search'"></SearchServiceSettings>
                        <SocialShareSettings v-if="subtab==='share'"></SocialShareSettings>
                    </div>

                </div>
            </div>

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
    import SocialShareSettings from './SocialShareSettings.vue'

    export default {

        components: {
            SiteSettings,
            LoginSettings,
            MailSettings,
            UpdateSettings,
            SearchServiceSettings,
            SocialShareSettings,
        },

        data() {
            return {
                tab: 'services',
                subtab: 'share',
            }
        },
    }

</script>
