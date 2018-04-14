<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Upload</div>
                    <div class="card-body">
                        <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">
                        <div class="alert alert-danger" role="alert" v-if="failed">Something went wrong. please try again</div>
                        <div class="alert alert-info" role="alert" v-if="!uploadComplete && uploading && !uploadComplete && !failed">Video will be available at <a :href="videoUrl" target="_blank">{{ videoUrl }}</a></div>
                        <div class="alert alert-success" role="alert" v-if="uploadComplete">Upload complete. Video is now is processing
                            <a :href="videoUrl"> Go to your video</a>.</div>
                        <div id="video-form" v-if="uploading && !failed">
                            <br>
                            <div class="progress" v-if="!uploadComplete">
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" v-bind:style="{ width: fileProgress + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" v-model="title">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" v-model="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Visibility</label>
                                <select class="form-control" v-model="visibility">
                                    <option value="private">Private</option>
                                    <option value="public">Public</option>
                                    <option value="unlisted">Unlisted</option>
                                </select>
                            </div>
                            <small class="float-right">{{ saveStatus }}</small>
                            <button class="btn btn-default" type="submit" @click.prevent="update">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default
    {
        methods:{
          fileInputChange () {
              this.uploading = true ;
              this.failed = false ;
              this.file = document.getElementById('video').files[0] ;
              this.storeVideo().then( () => {
                  let formData = new FormData();
                  formData.append('video', this.file);
                  formData.append('uid', this.uid);
                  axios({
                      method: 'post',
                      url: this.$root.url + 'video/upload',
                      data: formData,
                      onUploadProgress: (e) => {
                          if (e.lengthComputable) {
                              this.updateProgress(e);
                          }
                      },
                  }).then(() => {
                      this.uploadComplete = true ;
                  }).catch((error) => {
                      this.failed = true ;
                      alert('Uploading failed');
                      console.log(error);
                  });
              });
          },
            storeVideo () {
                return axios({
                                method: 'post',
                                url:    this.$root.url + 'video/store',
                                data: {
                                    title:       this.title,
                                    description: this.description,
                                    visibility:  this.visibility,
                                    extension:   this.file.name.split('.').pop()
                                }
                            }).then(response => {
                                this.uid = response.data.data.uid ;
                                this.videoUrl = this.$root.url + 'videos/' + this.uid + '/show';
                            }).catch((error) => {
                                this.failed = true ;
                                alert('Something went wrong while saving video\'s properties');
                                console.log(error);
                            });
            },
            update () {
              axios.put(this.$root.url + 'videos/' + this.uid + '/update', {
                  title: this.title,
                  description: this.description,
                  visibility: this.visibility
              }).then( () => {
                  this.saveStatus = 'Changes saved' ;
                  setTimeout(() => {
                      this.saveStatus = null ;
                  }, 3000);
              }).catch( (error) => {
                  alert('Something went wrong while updating the video');
                  console.log(error);
              });
            },
            updateProgress (e) {
              e.percent = (e.loaded / e.total) * 100 ;
              this.fileProgress = e.percent ;
            }
        },
        data () {
            return {
                uploading: false,
                uploadComplete: false,
                failed: false,
                title: 'untitled',
                description: null,
                visibility: 'private',
                uid: null,
                saveStatus: null,
                fileProgress: 0,
                videoUrl: null,
            };
        },
        mounted () {
            window.onbeforeunload = () => {
                if (this.uploading && !this.uploadComplete && !this.failed)
                return 'ok';
            }
        },
    }
</script>