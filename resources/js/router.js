import Vue from "vue";
import VueRouter from 'vue-router';
import PostsComponent from './components/PostsComponent'
import CreatePostComponent from './components/CreatePostComponent'
import EditPostComponent from './components/EditPostComponent'
import ShowPostComponent from './components/ShowPostComponent'

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            name:PostsComponent,
            path: '/posts',
            component: PostsComponent    
         },
         {
            name: CreatePostComponent,
            path: '/create',
            component: CreatePostComponent    
         },
         {
            name: 'editpost',
            path: '/posts/edit/:id',
            component: EditPostComponent    
         },
         {
            name: 'showpost',
            path: '/post/show/:id',
            component: ShowPostComponent    
         }
    ],
   //  mode:'history',
    
})