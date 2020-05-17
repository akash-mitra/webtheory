<template>

    <div>
        <div class="w-full mb-3 py-4">
            <h4 class="text-xl">{{ comments.total }} Comments</h4>
        </div>

        <div>

            <div v-if="!!this.$root.$data.authuser" class="w-full flex p-4 bg-gray-100 border rounded-lg mb-2">

                <a  :href="this.$root.$data.authuser.id">
                    <img :src="this.$root.$data.authuser.avatar" class="h-12 w-12 rounded-full">
                </a>

                <div class="w-full text-sm px-4">
                    <div>
                        <span class="text-blue-800 font-bold">{{ this.$root.$data.authuser.name }}</span>
                        <span class="ml-3">&mdash; Join the discussion</span>
                    </div>

                    <div class="w-full text-gray-800">
                        <textarea v-model="comment" class="mt-2 border-2 rounded p-2 w-full h-12" onclick="this.classList.remove('h-12')"></textarea>

                        <div v-show="comment.length>0" class="w-full flex justify-end items-center mt-2">
                            <div>
                                <span class="text-xs text-gray-200">{{ comment.length }} characters</span>
                            </div>
                            <button @click="postComment" class="ml-3 bg-orange-600 text-white py-1 px-4 rounded hover:bg-orange-800">Post</button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="w-full flex p-4 bg-gray-100 border rounded-lg mb-4 justify-between items-center">
                <div class="text-xl">Join the Discussion.</div>
                <div class="bg-orange-600 text-white py-1 px-4 cursor-pointer rounded hover:bg-orange-800" @click.stop="showLoginOption">
                    Sign Up / Login
                </div>
            </div>

            <div v-for="comment in comments.data" class="w-full flex p-4 border-b border-gray-200">

                <a  :href="comment.user.url">
                    <img :src="comment.user.avatar" class="h-12 w-12 rounded-full">
                </a>

                <div class="w-full text-sm px-4">
                    <div class="pb-1">
                        <span class="text-blue-800 font-bold tracking-wide">{{ comment.user.name }}</span>
                        <span class="ml-1 text-gray-600">commented {{ comment.created_ago }}</span>
                    </div>

                    <div class="text-gray-800">
                        {{ comment.body }}
                    </div>

                    <div class="w-full flex justify-between py-1 text-gray-600 text-xs tracking-wide">
                        <div class="flex justify-start">
                            <button @click="openReplyBox(comment.id)" class="hover:text-orange-500">Reply</button>
                            <span v-show="false" class="text-gray-600">&nbsp;•&nbsp;</span>
                            <button v-show="false" class="hover:text-orange-500">Like</button>
                        </div>
                        <span v-if="comment.replies.length>1" class="hover:text-orange-500">{{ comment.replies.length }} Replies</span>
                    </div>

                    <div v-for="reply in comment.replies" class="w-full pt-6 flex">

                        <a  :href="reply.user.url">
                            <img :src="reply.user.avatar" class="h-12 w-12 rounded-full">
                        </a>

                        <div class="w-full text-sm px-4">

                            <div class="pb-1">
                                <span class="text-blue-800 font-semibold tracking-wide">{{ reply.user.name }}</span>
                                <span class="ml-1 text-gray-600">replied {{ reply.created_ago }}</span>
                            </div>

                            <div v-if="reply.body.length>0" class="text-gray-800">
                                {{ reply.body }}

                                <div class="w-full flex justify-between py-1 text-gray-600 text-xs tracking-wide">
                                    <div class="flex justify-start">
                                        <button @click="openReplyBox(reply.parent_id)" class="hover:text-orange-500">Reply</button>
                                        <span v-show="false" class="text-gray-600">&nbsp;•&nbsp;</span>
                                        <button v-show="false" class="hover:text-orange-500">Like</button>
                                    </div>

                                </div>
                            </div>

                            <div v-else class="w-full text-gray-800 bg-gray-100">
                                <textarea v-model="replyText" class="mt-2 border-2 rounded p-2 w-full h-12" onclick="this.classList.remove('h-12')"></textarea>

                                <div v-show="replyText.length>0" class="w-full flex justify-end items-center mt-2">
                                    <div>
                                        <span class="text-xs text-gray-200">{{ replyText.length }} characters</span>
                                    </div>
                                    <button @click="postReply(reply)" class="ml-3 bg-orange-600 text-white py-1 px-4 rounded hover:bg-orange-800">Post</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="comments.next_page_url != null" class="mt-4">
            <span @click="loadMoreComments" class="px-3 py-1 cursor-pointer text-blue-700 text-sm">Load more comments</span>
        </div>
    </div>

</template>

<script>

    export default {

        props: {
            content_type: { required: true, type: String },
            refid: { required: true, type: String },
        },

        data() {
            return {
                comments: {},
                comment: '',
                replyText:'',
                unsavedComment: {},
            }
        },

        created() {
            this.loadInitialComments()
        },

        methods: {

            loadInitialComments() {
                let p = this
                this.ajaxGet(this.getUrl(), function (response) {
                    p.comments = response
                })
            },


            loadMoreComments() {
                let p = this
                this.ajaxGet(this.getUrl(), function (response) {
                    let l = response.data.length
                    for (var i = 0; i < l; i++) {
                        p.comments.data.push(response.data[i])
                    }
                    p.comments.next_page_url = response.next_page_url
                })
            },


            postComment() {

                let c = {
                    body: this.comment,
                    created_ago: 'just now',
                    replies: [],
                    user: this.$root.$data.authuser
                }, p = this

                this.ajaxPost(this.postUrl(), c, function (response) {
                    p.comments.data.unshift(c)
                })
            },


            postReply(reply) {

                let p = this

                this.ajaxPost(this.postUrl(), {
                    'body': this.replyText,
                    'parent_id': reply.parent_id

                }, function (response) {
                    reply.body = p.replyText
                    p.replyText = ''
                })
            },


            openReplyBox(id) {

                let parentComment = this.comments.data.filter(comment => comment.id === id)[0]

                parentComment.replies.unshift({
                    body: '',
                    parent_id: id,
                    user: this.$root.$data.authuser
                })
            },

            ajaxGet(url, handler) {

                let xhttp = new XMLHttpRequest()

                xhttp.onreadystatechange = function() {
                    if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                        handler (JSON.parse(xhttp.responseText))
                    }
                }

                xhttp.open("GET", url, true)
                xhttp.send()
            },


            ajaxPost(url, data, handler) {

                let xhttp = new XMLHttpRequest()

                xhttp.onreadystatechange = function() {
                    if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                        handler (JSON.parse(xhttp.responseText))
                    }
                }

                xhttp.open("POST", url, true)

                xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

                data["_token"] = window.csrf_token;

                xhttp.send(JSON.stringify(data))
            },



            getUrl() {

                let type = (this.content_type === 'single')
                        ? 'pages'
                        : 'categories'

                return this.comments.next_page_url
                        ?? '/api/' + type + '/' + this.refid + '/comments'
            },



            postUrl() {

                let type = (this.content_type === 'single')
                        ? 'pages'
                        : 'categories'

                return '/api/' + type + '/' + this.refid + '/comments'
            },

            showLoginOption() {

                this.$root.$data.isLoginModalOpen = true

            }

        }
    }

</script>

<style scoped>
.comment-strip-style {

}

</style>