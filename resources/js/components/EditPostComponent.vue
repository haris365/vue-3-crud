<template>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <span>Edit Post</span>                    
                    </div>
                  
                    <div class="card-body">
                       <div class="container">
                         <form @submit.prevent="updatePost">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Post Name</label>
                              <input type="text" class="form-control" id="name" v-model="post.name">
                            </div>

                             <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Selected Tags</label>

                                <select class="form-select" multiple aria-label="Default select example" v-model="selected">
                                <option v-for="item in post.tags" disabled> {{item.name}}</option>
                                <option disabled>--Please Update Tags--</option>
                                <option v-for="tag in tags" :value="tag.id"> {{tag.name}}</option>

                                </select>
                            </div>

                             <div class="mb-3">
                                <div class="large-12 medium-12 small-12 cell">
                                    <label>Upload File <br>
                                        <input accept="video/mp4,video/x-m4v,video/*" type="file" id="files" ref="files" multiple v-on:change="handleFilesUpload()"/>
                                    </label>
                                </div>

                            </div>
                             <div class="mb-3" v-for="video in post.videos">
                                        <video width="100%" height="240" controls>
                                        <source :src="'/'+video.path">
                                    </video>
                            </div>


                            <div class="large-12 medium-12 small-12 cell">
                                <div v-for="(file, key) in videos" class="file-listing">{{ file.name }} </div>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Update</button>
                          </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
           name: '',                
            tags:[],
            selected:[],
            attach : [],
            videos : [],
            files: [],
            post:[]
        }
    }, 
    mounted() {
        
            axios.get(`/posts/edit/${this.$route.params.id}`)
                .then(response => {
                    
                     this.post  = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });

            axios.get('/tags')
                .then(response => {
                   
                    this.tags = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
       
    },
    methods: {
        updatePost() {
            console.log(this.post.name);
            
            
            let formData = new FormData();
                formData.append('name', this.post.name);

                 for (const i of Object.keys(this.selected)) {
                    formData.append('tags[]', this.selected[i])
                }
               

                for( var i = 0; i < this.files.length; i++ ){
                    let file = this.files[i];

                formData.append('files[' + i + ']', file);
                }
            
                axios.post(`/posts/update/${this.$route.params.id}`, formData)
                    .then(response => {
                        this.$router.push('/posts');
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            
        },handleFilesUpload(){
                let uploadedFiles =this.$refs.files.files;

                /*
                    Adds the uploaded file to the files array
                */
                for( var i = 0; i < uploadedFiles.length; i++ ){
                    this.files.push( uploadedFiles[i] );
                }
            },removeFile( key ){
                this.files.splice( key, 1 );
            }
    },
  
}
</script>