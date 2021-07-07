<template>
    <div>
        <div v-if="$root.authenticated">
            <p>{{ comments.length === 1 ? comments.length + ' comment' : comments.length + ' comments' }}</p>
            <div class="video-comment clear-fix" v-if="$root.authenticated">
                <textarea v-model="body" placeholder="Say something" class="form-control video-comment-input" ></textarea>
                <div class="float-right">
                    <button type="submit" class="btn btn-default" @click.prevent="createComment">Post</button>
                </div>
            </div>
            <ul class="media-list">
                <li class="media" v-for="comment in comments">
                    <div class="media-left">
                        <a :href="comment.channel.data.channelUrl">
                            <img :src="comment.channel.data.image" :alt="comment.channel.data.name" class="media-object">
                        </a>
                    </div>
                    <div class="media-body">
                        <a :href="comment.channel.data.channelUrl">{{ comment.channel.data.name }}</a>&nbsp; {{ comment.created_at_human }}
                        <p>{{ comment.body }} </p>
                        <ul class="list-inline" v-if="$root.authenticated">
                            <li class="list-inline-item">
                                <a class="btn btn-sm btn-default " href="#" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? 'Cancel' : 'Reply' }}</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" @click.prevent="deleteComment(comment.id)" v-if="$root.id === comment.user_id" class="btn btn-sm btn-default">Delete</a>
                            </li>
                        </ul>
                        <div class="video-comment clear" v-if="replyFormVisible === comment.id ">
                            <textarea v-model="replyBody" class="form-control video-comment-input" placeholder="Say something"></textarea>
                            <div class="float-right">
                                <button type="submit" class="btn btn-default" @click.prevent="createReply(comment.id)">Reply</button>
                            </div>
                        </div>
                        <div class="media" v-for="reply in comment.replies.data">
                            <div class="media-left">
                                <a :href="reply.channel.data.channelUrl">
                                    <img :src="reply.channel.data.image" :alt="reply.channel.data.name" class="media-object">
                                </a>
                            </div>
                            <div class="media-body">
                                <a :href="reply.channel.data.channelUrl">{{ reply.channel.data.name }}</a>&nbsp; {{ reply.created_at_human }}
                                <p>{{ reply.body }} </p>
                                <ul class="list-inline">
                                    <li v-if="$root.id === reply.user_id">
                                        <a href="#" @click.prevent="deleteComment(reply.id)" class="btn btn-sm btn-default">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div v-else>
            <p><a :href="$root.url + 'login'">login to comment and post and reply</a></p>
        </div>

    </div>
</template>

<script>
    export default
    {
        props: {
            uid: null,
        },
        data () {
            return {
                comments: [],
                body: null,
                replyBody: null,
                replyFormVisible: null,
                rootUrl: null,
            };
        },
        methods: {
            getComments () {
              axios.get(this.rootUrl + 'videos/' + this.uid + '/comments')
                  .then(response => {
                      this.comments = response.data.data ;
                  }).catch(error => {
                  alert('Something went wrong while getting comments');
                  console.log(error);
              });
            },
            createComment () {
                if (this.body !== null &&  this.body !== '')
                axios.post(this.rootUrl + 'videos/' + this.uid + '/comment/store', {
                    body: this.body,
                }).then(response => {
                    this.comments.unshift(response.data.data);
                    this.body = null ;
                }).catch(error => {
                    alert('Something went wrong while saving your comment');
                    console.log(error);
                });
            },
            createReply (commentId) {
                if (this.replyBody !== null &&  this.replyBody !== '')
                    axios.post(this.rootUrl + 'videos/' + this.uid + '/comment/store', {
                        body: this.replyBody,
                        reply_id: commentId,
                    }).then(response => {
                        this.comments.map((comment, index) => {
                           if (comment.id === commentId) {
                               this.comments[index].replies.data.push(response.data.data);
                               return null;
                           }
                        });
                        this.replyBody = null ;
                        this.replyFormVisible = null ;
                    }).catch(error => {
                        alert('Something went wrong while saving your reply');
                        console.log(error);
                    });
            },
            toggleReplyForm (commentId) {
                this.replyBody = null ;
                if (this.replyFormVisible === commentId) {
                    this.replyFormVisible = null ;
                    return null;
                }
                this.replyFormVisible = commentId ;
            },
            deleteComment (commentId) {
                if (!confirm('Are you sure you want to delete this comment')) {
                    return null;
                }
                this.deleteById(commentId);
                this.deleteInBackEnd(commentId);
            },
            deleteById (commentId) {
                this.comments.map((comment, index) => {
                    if (comment.id === commentId) {
                        this.comments.splice(index, 1);
                        return null;
                    }
                    comment.replies.data.map((comment, replyIndex) => {
                        if (comment.id === commentId) {
                            this.comments[index].replies.data.splice(replyIndex, 1);
                            return null;
                        }
                    });
                });
            },
            deleteInBackEnd (commentId) {
                axios({
                    method: 'delete',
                    url: this.rootUrl + 'videos/' + this.uid + '/comments/' + commentId + '/delete',
                }).catch(error => {
                    alert('Something went wrong while deleting comment in the backend');
                    console(error);
                });
            },
            listen () {
                console.log('changes saved');
                Echo.private('videos' + this.uid)
                    .listen('CreateNewComment', (response) => {
                        if (response.data.ReplyId === null ) {
                            this.comments.unshift(response.data);
                        } else {
                            this.comments.map((comment, index) => {
                                if (comment.id === response.data.ReplyId )
                                    this.comments[index].replies.data.push(response.data);
                            });
                        }
                    })
            },
        },
        mounted () {
            this.rootUrl = this.$root.url;
            if (this.$root.authenticated) {
                this.getComments();
                this.listen();
            } else {
                return null;
            }
        },
    }
</script>

<style scoped>

</style>