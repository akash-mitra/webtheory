<template>

    <div>
        <div class="w-full mb-3 py-4">
            <h4 class="text-xl">{{ comments.total }} Comments</h4>
        </div>

        <div>

            <div v-if="!!authUser" :class="boxClass">

                <a  :href="authUser.url">
                    <img :src="authUser.avatar" class="h-12 w-12 rounded-full">
                </a>

                <div class="w-full text-sm px-4">
                    <div>
                        <span :class="linkClass">{{ authUser.name }}</span>
                        <span class="ml-3" :class="textClass">&mdash; Join the discussion</span>
                    </div>

                    <div class="w-full text-gray-800">
                        <textarea
                            v-model="comment"
                            :class="textBoxClass"
                            onclick="this.classList.remove('h-12')"
                        ></textarea>

                        <div v-show="comment.length>0" class="w-full flex justify-end items-center mt-2">
                            <div>
                                <span :class="textClass">{{ comment.length }} characters</span>
                            </div>

                            <button @click="postComment" :class="buttonClass" :disabled="networkActionInProgress">Post</button>

                        </div>
                    </div>
                </div>
            </div>

            <div v-else :class="commentInviteClass">
                <div>Join the Discussion.</div>
                <div :class="buttonClass" @click.stop="showLoginOption">
                    Sign Up / Login
                </div>
            </div>

            <div v-for="comment in comments.data" class="w-full flex p-4">

                <a  :href="comment.user.url">
                    <img :src="comment.user.avatar" class="h-12 w-12 rounded-full">
                </a>

                <div class="w-full text-sm px-4">
                    <div class="pb-1">
                        <span :class="linkClass">{{ comment.user.name }}</span>
                        <span :class="textClass">commented {{ comment.created_ago }}</span>
                    </div>

                    <div :class="commentClass">
                        {{ comment.body }}
                    </div>

                    <div class="w-full flex justify-between py-1 text-gray-600 text-xs tracking-wide">
                        <div class="flex justify-start">
                            <button
                                v-if="!!authUser"
                                @click="openReplyBox(comment.id)"
                                :class="replyTextClass"
                            >
                                Reply
                            </button>
                            <span v-show="false" class="text-gray-600">&nbsp;•&nbsp;</span>
                            <button v-show="false" class="hover:text-orange-500">Like</button>
                        </div>
                        <span v-if="comment.replies.length>1" :class="replyTextClass">{{ comment.replies.length }} Replies</span>
                    </div>

                    <div v-for="reply in comment.replies" class="w-full pt-6 flex">

                        <a  :href="reply.user.url">
                            <img :src="reply.user.avatar" class="h-12 w-12 rounded-full">
                        </a>

                        <div class="w-full text-sm px-4">

                            <div class="pb-1">
                                <span :class="linkClass">{{ reply.user.name }}</span>
                                <span :class="textClass">replied {{ reply.created_ago }}</span>
                            </div>

                            <div v-if="reply.body.length>0" :class="commentClass">
                                {{ reply.body }}

                                <div class="w-full flex justify-between py-1 text-xs tracking-wide">
                                    <div class="flex justify-start">
                                        <button @click="openReplyBox(reply.parent_id)" :class="replyTextClass">Reply</button>
                                        <span v-show="false" class="text-gray-600">&nbsp;•&nbsp;</span>
                                        <button v-show="false" class="hover:text-orange-500">Like</button>
                                    </div>

                                </div>
                            </div>

                            <div v-else>
                                <textarea v-model="replyText" :class="textBoxClass" onclick="this.classList.remove('h-12')"></textarea>

                                <div v-show="replyText.length>0" class="w-full flex justify-end items-center mt-2">
                                    <div>
                                        <span :class="textClass">{{ replyText.length }} characters</span>
                                    </div>
                                    <button @click="postReply(reply)" :class="buttonClass" :disabled="networkActionInProgress">Post</button>
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

            boxClass: { type: String, default: 'w-full flex p-4 rounded-lg mb-2 pb-6 bg-gray-100 border' },
            textBoxClass: { type: String, default: 'mt-2 rounded-lg p-2 w-full h-12 border-2' },
            buttonClass: { type: String, default: 'ml-3 bg-orange-600 text-white py-1 px-4 rounded hover:bg-orange-800' },
            linkClass: { type: String, default: 'font-bold text-blue-800' },
            commentClass: { type: String, default: 'text-gray-800' },
            textClass: { type: String, default: 'text-gray-800' },
            replyTextClass: { type: String, default: 'hover:text-orange-500' },
            commentInviteClass: { type: String, default: 'w-full flex p-4 border rounded-lg mb-4 justify-between items-center' },

        },

        data() {
            return {
                comments: {},
                comment: '',
                replyText:'',
                unsavedComment: {},
                authUser: false,
                networkActionInProgress: false,
            }
        },

        created() {
            this.authUser = this.$root.$data.authuser
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

                this.networkActionInProgress = true



                let c = {
                    body: this.comment,
                    created_ago: 'just now',
                    replies: [],
                    user: this.authUser
                }, p = this

                this.ajaxPost(this.postUrl(), c, function (response) {

                    // the response contains the comment data
                    // however, we must also add the "user"
                    // and replies with this.
                    response['user'] = c.user
                    response['replies'] = c.replies

                    p.comments.data.unshift(response)

                    p.networkActionInProgress = false

                }, function (error) {
                    console.log(error)
                    p.networkActionInProgress = false
                })
            },


            postReply(reply) {

                let p = this
                this.networkActionInProgress = true

                this.ajaxPost(this.postUrl(), {
                    'body': this.replyText,
                    'parent_id': reply.parent_id

                }, function (response) {
                    reply.body = p.replyText
                    p.replyText = ''
                    p.networkActionInProgress = false
                })
            },


            openReplyBox(id) {

                let parentComment = this.comments.data.filter(comment => comment.id === id)[0]

                parentComment.replies.unshift({
                    body: '',
                    parent_id: id,
                    user: this.authUser
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