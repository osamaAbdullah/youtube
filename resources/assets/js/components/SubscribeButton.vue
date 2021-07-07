<template>
    <div class="subscribe-button" >
        {{ subscribers > 1 ? subscribers + ' subscribers' : subscribers + ' subscriber'  }} &nbsp;
        <button class="btn btn-sm btn-default" type="button" v-if="canSubscribe" @click.prevent="handle">{{ userSubscribed ? 'Unsubscribe' : 'Subscribe' }}</button>
    </div>
</template>

<script>
    export default
    {
        props: {
          channelSlug: null,
        },
        mounted () {
            this.rootUrl = this.$root.url;
            this.getSubscriptionStatus ();
        },
        data () {
            return {
                subscribers: null,
                userSubscribed: false,
                canSubscribe: false,
                rootUrl: null,
            };
        },
        methods: {
            getSubscriptionStatus () {
                axios.get(this.rootUrl + 'channels/' + this.channelSlug + '/subscriptions')
                    .then(response => {
                        this.subscribers = response.data.count ;
                        this.userSubscribed = response.data.isSubscribed ;
                        this.canSubscribe = response.data.canSubscribe ;
                    }).catch(error => {
                        alert('Something went wrong while getting subscriptions info');
                        console.log(error);
                });
            },
            handle () {
                if (this.userSubscribed) {
                    this.unsubscribe();
                } else {
                    this.subscribe();
                }
            },
            subscribe () {
                this.userSubscribed = true ;
                this.subscribers++ ;
                axios.post(this.rootUrl + 'channels/' + this.channelSlug + '/subscriptions/store')
                   .catch(error => {
                    alert('Something went wrong while saving your subscription');
                    console.log(error);
                });
            },
            unsubscribe ()  {
                this.userSubscribed = false ;
                this.subscribers-- ;
                axios.delete(this.rootUrl + 'channels/' + this.channelSlug + '/subscriptions/delete')
                    .catch(error => {
                    alert('Something went wrong while deleting your subscription');
                    console.log(error);
                });
            },
        },
    }
</script>

<style scoped>

</style>