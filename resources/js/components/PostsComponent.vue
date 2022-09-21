<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8"  style="width: 100% !important">
                <div class="card">
                    <div class="card-header">
                        
                        <router-link class="btn btn-success" to="/create">Create</router-link>
                    </div>
                  
                    <div class="card-body">
                       <div class="container">
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                         <th>Tags</th>
                                        <th>Videos</th>                                       
                                        <th>Actions</th>
                                    </tr>

                                </thead>
                                <tbody>
                                <tr v-for="(post, index) in posts">
                                    <td>{{post.name }}</td>
                                   
                                    <td data-role="tagsinput" >
                        
                                        <button type="button" class="btn btn-primary btn-sm mr-1" disabled v-for="tag in post.tags">{{tag.name}}</button>

                                    </td>
                                     <td >
                                         <span v-for="video in post.videos">{{video.name}}</span>
                                    </td>
                                    
                                    <td>        
                                        <router-link style="color: inherit;" :to="{name: 'showpost', params: { id: post.id }}" class="fa fa-eye"></router-link>                               
                                        <router-link v-if="user.id === post.user.id"  style="color: inherit;" :to="{name: 'editpost', params: { id: post.id }}" class="fa fa-pencil-square-o"></router-link>
                                        <li v-if="user.id === post.user.id" class="fa fa-trash" @click="deletePost(post.id,index)"></li>

                                    </td>
                                </tr>
                            
                                </tbody>
                            </table>
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
            posts: [],
            user:{}
        }
    },
    created() {
           axios.get('/posts')
                .then(response => {
                    
                    this.posts = response.data.posts;
                    this.user = response.data.user;
                })
                .catch(function (error) {
                    console.error(error);
                });
        
    },
    methods: {
        deletePost(id,index) {
            if(confirm("Do you really want to delete?"))
            {

                axios.delete(`/posts/delete/${id}`)
                    .then(response => {
                        let i = this.posts.map(item => item.id).indexOf(id); 
                         
                        this.posts.splice(i, 1)
                            
                    })
                    .catch(function (error) {
                        console.error(error);
                    });                    
            }                                       
        }
    },
   
  
}
</script>
