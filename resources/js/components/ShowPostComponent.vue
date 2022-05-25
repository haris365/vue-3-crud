<style>
.image:hover {
    filter: brightness(1.2);
}
</style>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span>Show</span>
                    </div>

                    <div class="card-body">
                        <div class="container">
                            <div class="float-start" style="margin-top: -10px">
                                <img
                                    class="rounded-circle mt-2"
                                    width="40px"
                                    height="40px"
                                    v-bind:src="user.path"
                                />
                            </div>
                            <div
                                class="rounded-pill"
                                style="margin-left: 50px; font-size: large"
                            >
                                {{ user.name }}
                            </div>
                            <span style="margin-left: 10px">{{
                                post.date
                            }}</span>

                            <br />

                            <div class="mb-3">
                                <span>{{ post.name }}</span>
                            </div>

                            <div class="mb-3" v-for="video in post.videos">
                                <video width="100%" height="240" controls>
                                    <source :src="'/' + video.path" />
                                </video>
                            </div>

                            <div class="mb-3">
                                <label
                                    for="exampleInputEmail1"
                                    class="form-label"
                                    >Selected Tags</label
                                >
                                <span
                                    class="badge badge-primary mx-1"
                                    v-for="item in post.tags"
                                >
                                    {{ item.name }}</span
                                >
                            </div>
                            <span class="border:1px solid red">{{ likes_count }} Likes</span>
                            <span style="margin-left:82%"  v-on:click="
                                            commentHidden = !commentHidden
                                        "> <u>{{ comments_count }} Comment</u></span>
                            <hr />
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm" @click="switchImage">
                                        <img
                                            width="20px"
                                            height="20px"
                                            style="
                                                margin-top: -7px;
                                                margin-right: 2px;
                                            "
                                            v-if="image"
                                            :key="image.id"
                                            class="image"
                                            :src="image.src"
                                            alt="image.alt"
                                        />

                                        <!-- <img v-for="like in post.likes" v-if="likeLenght > 0 && auth.id === like.user.id" :src="'http://vue-3.test/images/clike.png'" width="20px" height="20px" style="margin-top:-7px;margin-right:2px"> -->

                                        <a
                                            @click="like(post.id)"
                                            style="
                                                color: inherit;
                                                text-decoration: none;
                                            "
                                            >Like</a
                                        >
                                    </div>

                                    <div
                                        class="col-sm"
                                        v-on:click="
                                            commentHidden = !commentHidden
                                        "
                                    >
                                        <img
                                            :src="'http://vue-3.test/images/comment.png'"
                                            width="20px"
                                            height="20px"
                                        />
                                        Comment
                                    </div>
                                    <div class="col-sm" v-on:click="share">
                                        <img
                                            :src="'http://vue-3.test/images/share.png'"
                                            width="20px"
                                            height="20px"
                                        />
                                        Share
                                    </div>
                                </div>
                            </div>

                            <hr />

                            <form
                                @submit.prevent="addComment"
                                v-if="!commentHidden"
                            >
                                <div class="mb-3">
                                    <label
                                        for="exampleInputEmail1"
                                        class="form-label"
                                        >Comments</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="post.comment"
                                        placeholder="Please leave a comment"
                                    /><br />
                                    <button
                                        class="btn btn-success btn-lg btn-block"
                                    >
                                        Comment
                                    </button>
                                </div>
                            </form>

                            <div
                                class="mb-3"
                                v-for="(comment,key) in post.comments"
                                v-if="!commentHidden"
                            >
                                <img
                                    class="rounded-circle mt-3 mr-3 ml-2"
                                    style="float: left"
                                    width="40px"
                                    height="40px"
                                    v-bind:src="comment.user.path"
                                />

                                <div
                                    class="rounded-pill"
                                    style="border: border:1px solid grey;padding: 15px;background-color:#f0f2f5"
                                >
                                    <h5>{{ comment.user.name }}</h5>
                                    <br />
                                    <div
                                        style="
                                            margin-top: -22px;
                                            margin-left: 40px;
                                        "
                                    >
                                        {{ comment.body }}
                                    </div>
                                </div>
                                <div
                                    v-for="reply in comment.replies"
                                    class="ml-5 rounded-pill"
                                    style="border: border:1px solid red;background-color:#e1e1e1;width:94%;margin-top:10px"
                                >
                                    <img
                                        class="rounded-circle mt-2 mr-3"
                                        style="float: left; margin-left: 10px"
                                        width="40px"
                                        height="40px"
                                        v-bind:src="reply.user.path"
                                    />
                                    <h5>{{ reply.user.name }}</h5>
                                    <br />

                                    <div
                                        class="rounded-pill"
                                        style="
                                            margin-top: -22px;
                                            margin-left: 40px;
                                        "
                                    >
                                        {{ reply.reply }}
                                    </div>
                                </div>

                                <a
                                    type="button"
                                    class="btn btn-light btn-sm mt-1"
                                    v-on:click="toggleReply(key)"
                                    >Reply</a
                                >
                                <form @submit.prevent="addReply(comment.id)">
                                    <input
                                        style="width: 94%"
                                        type="text"
                                        :id="'reply'+key"
                                        class="form-control ml-5 mt-3 reply"
                                        name="reply"
                                        value=""
                                        :key="key"
                                        ref="inputRef"
                                        v-on:change="changeItem($event)"
                                        :placeholder="functionData(comment)"
                                        v-if="!isHidden"
                                    />
                                </form>
                                <hr />
                            </div>
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
            post: [],
            user: {},
            img: "",
            auth: "",
            reply: "",
            likeLenght: 0,
            isHidden: false,
            commentHidden: false,
            likes_count: 0,
            comments_count: 0,
            image: null,
            index: 0,
            images: [
                {
                    id: 1,
                    src: "http://vue-3.test/images/like.png",
                },
                {
                    id: 2,
                    src: "http://vue-3.test/images/clike.png",
                },
            ],
        };
    },
    mounted() {
        this.switchImage();
        this.showPost();
    },
    methods: {
        showPost() {
            axios
                .get(`/post/show/${this.$route.params.id}`)
                .then((response) => {
                    console.log(response.data.post.comments.length);
                    this.likeLenght = response.data.post.likes.length;
                    this.likes_count = response.data.likes_count;
                    this.post = response.data.post;
                    this.auth = response.data.user;
                    this.user = response.data.post.user;
                    this.comments_count = response.data.post.comments.length
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        addComment() {
            let data = {
                comment: this.post.comment,
                post_id: this.$route.params.id,
            };

            axios
                .post(`/post/${this.$route.params.id}/comment`, data)
                .then((response) => {
                    this.showPost();
                    this.comment = "";
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        addReply(comment_id) {
            let data = {
                comment_id: comment_id,
                reply: this.reply,
            };

            axios
                .post(`/post/${this.$route.params.id}/comment/reply`, data)
                .then((response) => {
                    this.showPost();
                    $(".reply").val("");
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
        functionData(comment) {
            return "Leave a Reply for " + comment.user.name;
        },
        changeItem(event) {
            this.reply = event.target.value;
        },
        like(post_id) {
            axios
                .post(`/post/${this.$route.params.id}/like`)
                .then((response) => {})
                .catch(function (error) {
                    console.error(error);
                });
        },
        share() {
            alert("Share Functionality Comming Soon");
        },
        switchImage() {
            this.image = this.images[this.index];
            this.index = (this.index + 1) % this.images.length;
        },
        toggleReply(key)
        {
            
        //     $(this).attr("class","newclass");

        //    const myElement = $("#reply"+key).addClass("important blue");;
        //    console.log('myElement',myElement)

           $('#reply'+key).toggle();
        }
    },
};
</script>
