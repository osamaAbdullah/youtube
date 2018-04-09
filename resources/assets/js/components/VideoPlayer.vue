<template>
    <video id="video" class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9" controls preload="auto" data-setup='{"fluid": true, "preload": "auto"}' v-bind:poster="thumbnailUrl">
        <source type="video/mp4" v-bind:src="videoUrl"></source>
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
            }
        },
        mounted () {
            this.payer = videojs('video') ;
            this.payer.on('loadedmetadata', () => {
                this.duration = Math.round(this.payer.duration()) ;
            });
            setInterval(() => {
                if (this.hasHitQuotaView()) {
                    this.storeView();
                }
            }, 1000);
        },
        props: {
            videoId: null,
            videoUrl: null,
            thumbnailUrl: null,
            storeViewUrl: null,
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
                    url: this.storeViewUrl,
                    data: {

                    },
                }).then(() => {

                }).catch(() =>{

                });
            },
        }
    }
</script>

<!--<style scoped>-->

<!--</style>-->