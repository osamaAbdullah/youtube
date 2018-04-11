<template>
    <div>
        <p>{{ comments.length === 1 ? comments.length + ' comment' : comments.length + ' comments' }}</p>
        <div class="video-comment clear-fix" v-if="">

        </div>
        <ul class="media-list">
            <li class="media" v-for="comment in comments">
                <div class="col-sm-1">
                    <div class="media-left">
                        <a :href="comment.channel.data.slug">
                            <img :src="comment.channel.data.image" :alt="comment.channel.data.name" class="media-object">
                        </a>
                    </div>
                </div>
               <div class="col-sm-11">
                   <div class="media-body">
                       <a :href="comment.channel.data.slug">{{ comment.channel.data.name }}</a>&nbsp; {{ comment.created_at_human }}
                       <p>{{ comment.body }} </p>
                       <div class="media" v-for="reply in comment.replies.data">
                           <div class="col-sm-1">
                               <div class="media-left">
                                   <a :href="reply.channel.data.slug">
                                       <img :src="reply.channel.data.image" :alt="reply.channel.data.name" class="media-object">
                                   </a>
                               </div>
                               <div class="media-body">
                                   <a :href="reply.channel.data.slug">{{ reply.channel.data.name }}</a>&nbsp; {{ reply.created_at_human }}
                                   <p>{{ reply.body }} </p>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default
    {
        props: {
            getCommentsUrl: null,
        },
        data () {
            return {
                comments: [],
            };
        },
        methods: {
            getComments () {
              axios.get(this.getCommentsUrl)
                  .then(response => {
                      this.comments = response.data.data ;
                  }).catch(error => {
                      alert(error);
              });
            },
        },
        created () {
            this.getComments();
        }
    }
</script>

<style scoped>

</style>