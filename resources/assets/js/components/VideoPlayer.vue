<template>
    <video id="video" class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9" controls preload="auto" data-setup='{"fluid": true, "preload": "auto"}' :poster="thumbnailUrl">
        <source type="video/mp4" :src="videoUrl">
    </video>
</template>

<script>
    import videojs from "video.js";

    export default
    {
        data () {
            return {
                player: null,
                duration: 0,
                rootUrl: null,
                viewed: false,
            }
        },
        mounted () {
            this.rootUrl = this.$root.url;
            this.payer = videojs('video');
            this.payer.on('loadedmetadata', () => {
                this.duration = Math.round(this.payer.duration());
            });
            setInterval(() => {
                if (!this.viewed) {
                    if (this.hasHitQuotaView()) {
                        this.storeView();
                        this.viewed = true;
                    }
                } else {
                    return null;
                }

            }, 1000);
        },
        props: {
            uid: null,
            videoUrl: null,
            thumbnailUrl: null,
        },
        methods: {
            hasHitQuotaView () {
                if (!this.duration) {
                    return false ;
                }
                return Math.round(this.payer.currentTime()) === Math.round((10 * this.duration ) / 100 ) ;
            },
            storeView () {
                axios({
                    method: 'post',
                    url: this.rootUrl + 'videos/' + this.uid + '/view/store',
                }).catch((error) => {
                    alert('Something went wrong while saving the view');
                    console.log(error);
                });
                //another way of doing this
                // axios.post(this.storeViewUrl)
                //     .then(() => {
                //
                //     }).catch((error) =>{
                //     alert('Something went wrong while saving the view');
                //     console.log(error)
                // });
            },
        }
    }
</script>

<!--<style scoped>-->

<!--</style>-->