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

                <div @click="tab='mail'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='mail'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    Mail
                </div>

                <div @click="tab='maintain'" class="px-4 text-sm tracking-wide uppercase cursor-pointer" :class="tab==='maintain'? 'text-gray-700 py-2 border-b-4 border-blue-500': 'text-gray-500 py-2'">
                    maintain
                </div>

            </div>
        </div>


        <div v-if="tab=='site'">

            <SiteSettings></SiteSettings>

        </div>


        <div v-if="tab=='login'">

            <LoginSettings></LoginSettings>

        </div>


        <div v-if="tab=='mail'">

            <MailSettings></MailSettings>

        </div>


        <div v-if="tab=='maintain'">

            <UpdateSettings></UpdateSettings>

        </div>

    </div>
</template>

<script>

    import SiteSettings from './SiteSettings.vue'
    import LoginSettings from './LoginSettings.vue'
    import MailSettings from './MailSettings.vue'
    import UpdateSettings from './UpdateSettings.vue'

    export default {

        components: {
            SiteSettings,
            LoginSettings,
            MailSettings,
            UpdateSettings,
        },

        data() {
            return {
                tab: 'site',
            }
        },
    }

</script>
