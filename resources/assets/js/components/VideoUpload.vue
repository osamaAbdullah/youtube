<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Upload</div>
                    <div class="card-body">
                        <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">
                        <div class="alert alert-danger" role="alert" v-if="failed">Something went wrong. please try again</div>
                        <div class="alert alert-info" role="alert" v-if="!uploadComplete && uploading && !uploadComplete && !failed">Video will be available at <a
                                :href="$root.url + 'videos/' + uid" target="_blank">{{ $root.url }}/videos/{{ uid }}</a></div>
                        <div class="alert alert-success" role="alert" v-if="uploadComplete">Upload complete. Video is now is processing
                            <a :href="$root.url + 'videos/' + uid"> Go to your video</a>.</div>
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
                      url: 'http://localhost:8080/projects/laravel/main/public/video/upload',
                      maxContentLength: 100000,
                      data: formData,
                      onUploadProgress: (e) => {
                          if (e.lengthComputable) {
                              this.updateProgress(e);
                          }
                      },
                  }).then( () => {
                      this.uploadComplete = true ;
                  }).catch( () => {
                      this.failed = true ;
                  });
              });

          },
            storeVideo () {
                return axios({
                                method: 'post',
                                url:    'http://localhost:8080/projects/laravel/main/public/video/store',
                                data: {
                                    title:       this.title,
                                    description: this.description,
                                    visibility:  this.visibility,
                                    extension:   this.file.name.split('.').pop()
                                }
                            }).then( response => {
                                this.uid = response.data.data.uid ;
                            }).catch( () => {
                                this.failed = true ;
                            });
            },
            update () {
              axios.put('http://localhost:8080/projects/laravel/main/public/videos/' + this.uid + '/update', {
                  title: this.title,
                  description: this.description,
                  visibility: this.visibility
              }).then( () => {
                  this.saveStatus = 'Changes saved' ;
                  setTimeout(() => {
                      this.saveStatus = null ;
                  }, 3000);
              }).catch( () => {
                  this.failed = true ;
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