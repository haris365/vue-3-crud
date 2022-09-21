<template>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">

                      <span>Post Create</span>
                    </div>

                    <div class="card-body">
                       <div class="container">


                         <form @submit.prevent="addPost">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Post Name</label>
                              <input type="text" class="form-control" id="name" v-model="name" placeholder="Please Enter Post Name" required>

                            </div>
                             <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Select Tags</label>

                              <select class="form-select" multiple aria-label="Default select example" v-model="selected" required>
                                <option disabled="disable">Select Tags</option>
                                <option v-for="tag in tags" :value="tag.id"> {{tag.name}}</option>

                            </select>

                            </div>

                            <div class="mb-3">
                                <div class="large-12 medium-12 small-12 cell">
                                <label>Upload File <br>
                                    <input accept="video/mp4,video/x-m4v,video/*" type="file" id="files" ref="files" multiple v-on:change="handleFilesUpload()" required    />
                                </label>
                            </div>

                            </div>
                            <div class="large-12 medium-12 small-12 cell">
                                <div v-for="(file, key) in files" class="file-listing">{{ file.name }} <span class="remove-file" v-on:click="removeFile( key )">Remove</span></div>
                            </div>


                            <button type="submit" class="btn btn-primary">Submit</button>
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
                post: {},
                tags:[],
                selected:[],
                files: [],
                name:'',

            }
        },
        mounted()
        {

           axios.get('/tags')
                .then(response => {
                    name
                    this.tags = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });

        },

        methods: {

            addPost() {

                let formData = new FormData();
                formData.append('name', this.name);

                 for (const i of Object.keys(this.selected)) {
                    formData.append('tags[]', this.selected[i])
                }

                for( var i = 0; i < this.files.length; i++ ){
                let file = this.files[i];

                formData.append('files[' + i + ']', file);
                }

                axios.post('/posts/add', formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
                    .then(response => {

                        this.$router.push('/posts')
                    }
                    )
                    .catch(function (error) {
                        console.error("error",error);

                    });

            },

            handleFilesUpload(){
                let uploadedFiles =this.$refs.files.files;

                for( var i = 0; i < uploadedFiles.length; i++ ){
                    this.files.push( uploadedFiles[i] );
                }
            },removeFile( key ){
                this.files.splice( key, 1 );
            }


        }
    }
</script>

