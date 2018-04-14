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
              axios.get(this.$root.url +'videos/' + this.videoUid + '/votes')
                  .then(response => {
                      this.up = response.data.data.up ;
                      this.down = response.data.data.down ;
                      this.userVote = response.data.data.userVote ;
                      this.canVote = response.data.data.canVote ;
              }).catch(error => {
                  alert('Something went wrong while getting votes');
                  console.log(error);
              });
            },
            vote (type) {
                if (this.$root.authenticated) {
                    if (this.userVote === type) {
                        this[type]--;
                        this.userVote = null;
                        this.deleteVote();
                        return null;
                    }
                    else if (this.userVote) {
                        this[type == 'up' ? 'down' : 'up']--;
                    }
                    this[type]++;
                    this.userVote = type ;
                    this.createVote(type);
                } else {
                    alert('You must login to vote');
                    return null;
                }
            },
            deleteVote () {
                axios.delete(this.$root.url +'videos/' + this.videoUid + '/vote/delete')
                    .catch(error => {
                        alert('Something went wrong while deleting your vote');
                        console.log(error);
                    });
            },
            createVote (type) {
                axios.post(this.$root.url +'videos/' + this.videoUid + '/vote/store', {
                    type: type,
                }).catch(error => {
                    alert('Something went wrong while saving your vote');
                    console.log(error);
                });
            },
        }
    }
</script>

<!--<style scoped>-->

<!--</style>-->