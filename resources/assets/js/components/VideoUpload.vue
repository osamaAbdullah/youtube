<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Upload</div>
                    <div class="card-body">
                        <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">
                        <div id="video-form" v-if="uploading && !failed">
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
                      url: 'video',
                      maxContentLength: 100000,
                      transformRequest: formData,
                      onUploadProgress: (e) => {
                          if (e.lengthComputable) {
                              console.log(e.loaded);
                          }
                      },

                  }).then( response => {

                  }).catch( error => {

                  });
              });

          },
            storeVideo () {
                return axios({
                                method: 'post',
                                url:    'video/store',
                                data: {
                                    title:       this.title,
                                    description: this.description,
                                    visibility:  this.visibility,
                                    extension:   this.file.name.split('.').pop()
                                }
                            }).then( response => {
                                this.uid = response.data.data.uid ;
                            }).catch( error => {
                                alert(error);
                            });
            },
            update () {
              axios.put('videos/' + this.uid + '/update', {
                  title: this.title,
                  description: this.description,
                  visibility: this.visibility
              }).then( response => {
                  this.saveStatus = 'Changes saved' ;
                  setTimeout(() => {
                      this.saveStatus = null ;
                  }, 3000);
              }).catch( error => {
                  alert(error);
              });
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
            };
        }
    }
</script>