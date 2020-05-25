<template>

    <div class="w-full">

        <p class="text-sm text-gray-700 pb-3 uppercase">Site Information</p>

        <div class="bg-white rounded w-full lg:flex lg:justify-between mb-6 shadow">


            <div class="p-6 w-full lg:w-2/3">
                <div class="pb-4">
                    <label for="sitename" class="block">Website Name</label>
                    <input type="text" id="sitename" v-model="sitename" ref="sitename" placeholder="My Personal Blog" class="w-full max-w-2xl p-2 my-2 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                    <p class="text-xs text-gray-600">This is a human readable name of your website. <br/>
                    For example, if your website URL is profoundmelon.com, this can be "Profound Melon". <br />
                    </p>
                </div>

                <div class="pb-4">
                    <label for="siteTitle" class="block">Website Title</label>
                    <input type="text" id="siteTitle" v-model="sitetitle" ref="sitetitle" placeholder="My Personal Blog" class="w-full max-w-2xl p-2 my-2 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none">
                    <p class="text-xs text-gray-600">The site title is applicable to your entire site and not specific to a page. Site title is visible in the browser window.
                    <br/>This can be same or different from the <code>sitename</code>.</p>
                </div>

                <div class="pb-4">
                    <label for="sitedesc" class="block">Website Description</label>
                    <textarea id="sitedesc" v-model="sitedesc" ref="sitedesc" placeholder="Daily journals, ideas, viewpoints and photos of Mr. John Doe" class="w-full max-w-2xl p-2 my-2 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none"></textarea>
                    <p class="text-xs text-gray-600">Provide a short but accurate description about what this site is about. This information may be utilised by search bots.</p>
                </div>

            </div>


            <div class="p-6 w-full lg:w-1/3">

                <div>
                    <p class="pb-4">Site Logo</p>

                    <PhotoPicker
                        :image-src="sitelogo"
                        @picked="onLogoSelect"
                    ></PhotoPicker>

                    <div class="py-4 text-sm text-gray-700">
                        A sitelogo can be used in the templates or inside any communications from your website.
                    </div>
                </div>
                <div class="border-t py-6">
                    <p class="pb-4">Favicon</p>

                    <PhotoPicker
                        :image-src="siteicon"
                        @picked="onIconSelect"
                    ></PhotoPicker>

                    <div class="py-4 text-sm text-gray-700">
                        A favicon is a small image associated with this site. Use a small <code class="bg-gray-100 font-mono p-1">png</code> image of dimension <i>32px by 32px</i>.
                    </div>
                </div>

            </div>

        </div>

        <t-button :loadingWheel="isSaving" textSize="normal" @click.native="save">
            Save Configurations
        </t-button>
    </div>

</template>

<script>

import PhotoPicker from './PhotoPicker.vue'

export default {

        components: {
            PhotoPicker
        },

        data() {
            return {
                sitetitle: '',
                sitename: '',
                sitedesc: '',
                sitelogo: '',
                siteicon: '',

                isSaving: false,
                isLoading: true,
            }
        },

        created() {

            this.isLoading = true

            util.ajax ('get', '/api/parameters/siteinfo', {},  (response) => {

                let siteinfo = JSON.parse(response)

                this.sitetitle = siteinfo.title
                this.sitename = siteinfo.name
                this.sitedesc = siteinfo.desc
                this.sitelogo = siteinfo.logo
                this.siteicon = siteinfo.icon

                this.isLoading = false
            })
        },

        methods: {

            save () {

                this.isSaving = true

                let data = {
                    name: this.sitename,
                    title: this.sitetitle,
                    desc: this.sitedesc,
                    logo: this.sitelogo,
                    icon: this.siteicon,
                }

                let p = this

                util.ajax ('post', '/api/parameters/siteinfo', { "value": JSON.stringify(data) },
                function () {
                    p.isSaving = false
                    util.notifySuccess ('Saved', 'Site configurations are successfully saved.')
                })
            },


            onLogoSelect(image) {

                this.sitelogo = image.url

                this.save()

            },


            onIconSelect(image) {

                this.siteicon = image.url

                this.save()

            }

        }
}

</script>