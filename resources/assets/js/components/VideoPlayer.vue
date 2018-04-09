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
                player: null
            }
        },
        mounted () {
            this.payer = videojs('video') ;
        },
        props: {
            videoId: null,
            videoUrl: null,
            thumbnailUrl: null
        }
    }
</script>

<!--<style scoped>-->

<!--</style>-->