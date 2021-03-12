<template>
    <div>
        <div v-if="tab === 'info'" class="w-full my-2 px-12 py-3 rounded-lg">
            <div class="my-2">
                <div :class="labelClass">Profile Image</div>
                <div class="mb-2">
                    <TensorImageInput
                        :image-url="user.avatar"
                        @uploaded="imageUploaded"
                        image-class="max-w-24 max-h-24 cursor-pointer border-2 object-cover"
                    >
                    </TensorImageInput>
                </div>
            </div>

            <div class="my-2">
                <div :class="labelClass">Name</div>
                <div class="mb-2">
                    <input name="name" type="text" :class="inputClass" v-model="name" />
                </div>
            </div>

            <div class="my-2">
                <div :class="labelClass">About Me</div>
                <div class="mb-2">
                    <textarea name="about_me" :class="inputClass" v-model="aboutMe"></textarea>
                </div>
            </div>

            <div class="my-2">
                <div :class="labelClass">Gender</div>
                <div class="mb-2">
                    <select v-model="gender" :class="inputClass">
                        <option value="Not Specified" default>Not Specified</option>
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="my-2">
                <div :class="labelClass">Preferences</div>
                <div class="mb-2 inline-flex justify-center items-center">
                    <input
                        type="checkbox"
                        v-model="prefer_email"
                        class="mr-2 bg-transparent h-6 w-6 border"
                    />
                    Receive Notifications via Email.
                </div>
            </div>

            <div class="my-2">
                <div :class="labelClass">Security</div>
                <div class="mb-2">
                    <span
                        @click="tab = 'password'"
                        class="text-blue-600 cursor-pointer inline-block"
                        >Change Current Password</span
                    >
                </div>
                
                <div class="mb-2" v-if="user.google2fa">
                    <span
                        @click="disable2fa"
                        class="text-red-600 cursor-pointer inline-block"
                        >Disable Google 2FA</span
                    >
                </div>
                <div class="mb-2" v-else>
                    <span
                        @click="enable2fa"
                        class="text-blue-600 cursor-pointer inline-block"
                        >Enable Google 2FA</span
                    >
                </div>
            </div>

            <TensorFormError
                v-if="errors"
                :error-bag="errors"
                container-class="px-6 py-2 mt-6 -mb-8 bg-yellow-100 border border-orange-300"
            >
            </TensorFormError>

            <div class="mt-8 py-4">
                <button :class="btnClass" type="button" @click="save">Save</button>
                <span @click="cancel" class="ml-4 text-blue-600 cursor-pointer inline-block"
                    >Cancel</span
                >
            </div>
        </div>

        <div class="py-4 w-full" v-if="tab === 'password'">
            <TensorFormError
                v-if="errors"
                :error-bag="errors"
                container-class="px-6 py-2 mb-6 bg-yellow-100 border border-orange-300"
            >
            </TensorFormError>

            <div class="px-6 w-full mb-4">
                <label for="currrent_password" class="block text-gray-700 text-sm mb-2">
                    Current Password
                </label>

                <input
                    aria-label="Password"
                    v-model="current_password"
                    id="current_password"
                    type="password"
                    required=""
                    autocomplete="current-password"
                    class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                    placeholder="********"
                />
            </div>

            <div class="px-6 w-full mb-4">
                <label for="new_password" class="block text-gray-700 text-sm mb-2">
                    New Password
                </label>

                <input
                    aria-label="Password"
                    v-model="new_password"
                    id="new_password"
                    type="password"
                    required
                    class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                    placeholder="********"
                />

                <label for="new_password_confirrmation" class="block text-gray-700 text-sm my-2">
                    Re-type New Password
                </label>

                <input
                    aria-label="Password"
                    v-model="new_password_confirmation"
                    id="new_password_confirmation"
                    type="password"
                    required
                    class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                    placeholder="********"
                />
            </div>

            <div class="px-6 w-full mt-8 flex items-center">
                <span
                    @click="resetPassword"
                    class="block px-6 py-2 text-white bg-green-600 rounded cursor-pointer"
                    >Change Password</span
                >
                <span @click="tab = 'info'" class="ml-4 text-blue-600 cursor-pointer inline-block"
                    >Back</span
                >
            </div>

            <div class="px-6 w-full mt-4">
                {{ message }}
            </div>
        </div>

        <div class="py-4 w-full" v-if="tab === 'enable-google2fa'">
            <div class="text-2xl px-12 py-4 border-b mb-6">Two Factor Authentication</div>
            <div class="mb-4 px-12">
                <p class="text-md">Open up your 2FA mobile app and scan the following QR barcode:</p>
                <img class="my-4" alt="Image of QR barcode" :src="image"/>
                <p class="text-md">If your 2FA mobile app does not support scanning of QR barcodes, enter in the following number:</p>
                <p class="text-xl mt-4" v-text="secret"></p>
            </div>
            <div class="px-8 w-full mt-8 flex items-center">
                <span @click="cancel" class="ml-4 text-blue-600 cursor-pointer inline-block"
                    >Back</span
                >
            </div>
        </div>

        <div class="py-4 w-full" v-if="tab === 'disable-google2fa'">
            <div class="text-2xl px-12 py-4 border-b mb-6">Two Factor Authentication</div>
            <div class="mb-4 px-12">
                <p class="text-red-600 text-md">Google Two Factor Authentication has been disabled !!</p>
            </div>
            <div class="px-8 w-full mt-8 flex items-center">
                <span @click="cancel" class="ml-4 text-blue-600 cursor-pointer inline-block"
                    >Back</span
                >
            </div>
        </div>
    </div>
</template>

<script>
import * as Tensor from '../helpers/tensor.js'
import TensorImageInput from '../../ui/TensorImageInput.vue'
import TensorFormError from '../../ui/TensorFormError.vue'

export default {
    name: 'user-profile-editor',

    props: {
        user: {
            type: Object,
        },

        labelClass: {
            type: String,
            default: 'mt-4 mb-2 uppercase text-gray-500',
        },

        inputClass: {
            type: String,
            default:
                'w-full p-3 border rounded outline:none bg-transparent shadow-inner border-gray-500',
        },

        btnClass: {
            type: String,
            default: 'px-6 py-3 bg-green-500 text-lg text-white hover:bg-green-700 rounded',
        },

        editLinkClass: {
            type: String,
            default: 'cursor-pointer py-4 text-blue-600 hover:text-blue-700',
        },
    },

    components: {
        TensorImageInput,
        TensorFormError,
    },

    data() {
        return {
            avatarBase64Data: null,
            aboutMe: this.user.about_me,
            name: this.user.name,
            gender: this.user.gender,
            prefer_email: this.user.preferences.indexOf('mail') > -1,
            current_password: '',
            new_password: '',
            new_password_confirmation: '',

            tab: 'info',
            message: '',
            errors: null,

            image: null,
            secret: '',
        }
    },

    methods: {
        imageUploaded(avatarData) {
            this.avatarBase64Data = avatarData
        },

        save() {
            let preferences = []
            if (this.prefer_email) {
                preferences.push('mail')
            }
            let data = {
                name: this.name,
                about_me: this.aboutMe,
                gender: this.gender,
                preferences: preferences,
                // 'dob': this.user.dob,
            }

            if (this.avatarBase64Data) {
                data['avatar_base64'] = this.avatarBase64Data
            }

            Tensor.xpatch(
                '/api/profile',
                data,
                (response) => {
                    this.$emit('saved', response)
                },
                (error) => (this.errors = error)
            )
        },

        cancel() {
            this.$emit('cancelled')
        },

        resetPassword() {
            let data = {
                    current_password: this.current_password,
                    new_password: this.new_password,
                    new_password_confirmation: this.new_password_confirmation,
                },
                p = this

            Tensor.xpatch(
                '/api/users/password',
                data,
                function (response) {
                    p.message = 'Password Changed Successfully'
                },
                (error) => (this.errors = error)
            )
        },

        enable2fa() {
            let p = this

            Tensor.xpost(
                '/google2fa/enable',
                {},
                function (response) {
                    p.image = response.image
                    p.secret = response.secret
                    p.tab = 'enable-google2fa'
                },
                (error) => (this.errors = error)
            )
        },

        disable2fa() {
            let p = this

            Tensor.xpost(
                '/google2fa/disable',
                {},
                function (response) {
                    p.secret = response.status
                    p.tab = 'disable-google2fa'
                },
                (error) => (this.errors = error)
            )
        },
    },
}
</script>

<style>
.max-h-24 {
    max-height: 8rem;
}
.max-w-24 {
    max-width: 8rem;
}
</style>
