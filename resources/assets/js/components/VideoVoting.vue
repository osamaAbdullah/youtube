<template>
    <div class="video__voting">
        <a href="#" @click.prevent="vote('up')" class="video__voting-button" v-bind:class="{'video__voting-button--voted': userVote === 'up' }">
            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
        </a> {{ up }} &nbsp;
        <a href="#" @click.prevent="vote('down')" class="video__voting-button" v-bind:class="{'video__voting-button--voted': userVote === 'down' }">
            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
        </a> {{ down }}
    </div>
</template>

<script>
    export default
    {
        props: {
            videoUid: null,
            getVotesUrl: null,

        },
        data () {
            return {
                up: null,
                down: null,
                userVote: null,
                canVote: false,

            };
        },
        mounted () {
            this.getVotes();
        },
        methods: {
            getVotes () {
              axios.get(this.getVotesUrl)
                  .then(response => {
                      this.up = response.data.data.up ;
                      this.down = response.data.data.down ;
                      this.userVote = response.data.data.userVote ;
                      this.canVote = response.data.data.canVote ;
              }).catch(error => {

              });
            },
            vote (type) {
                if (this.userVote === type) {
                    this[type]--;
                    this.userVote = null;
                    this.deleteVote(type);
                    return null;
                }
                else if (this.userVote) {
                    this[type == 'up' ? 'down' : 'up']--;
                }
                this[type]++;
                this.userVote = type ;
                this.createVote(type);
            },
            deleteVote (type)
            {
                axios.delete(this.getVotesUrl.replace('votes','vote/delete'));
            },
            createVote (type)
            {
                axios.post(this.getVotesUrl.replace('votes','vote/store'), {
                    type: type,
                }).then().catch(error => {
                    alert(error);
                });
            },
        }
    }
</script>

<!--<style scoped>-->

<!--</style>-->