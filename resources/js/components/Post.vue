<template>
    <div class="container">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">
            Add New Post
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="edit" class="modal-title" id="exampleModalLabel">Edit Post</h5>
                        <h5 v-else class="modal-title" id="exampleModalLabel">Add New Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" :class="['form-control my-2',errors.title? 'is-invalid' : '']" placeholder="Enter Post Title" v-model="post.title">
                        <span class="bg-danger text-white p-1 rounded" v-if="errors.title">{{errors.title[0]}}</span>

                        <textarea :class="['form-control my-2',errors.body? 'is-invalid' : '']" placeholder="Enter Post Body" v-model="post.body"></textarea>
                        <span class="bg-danger text-white p-1 rounded" v-if="errors.body">{{errors.body[0]}}</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-if="edit" type="button" class="btn btn-success" @click="updatePost">Update</button>
                        <button v-else type="button" class="btn btn-success" @click="createPost">Create</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="my-3" v-for="post in posts" :key="post.id">
            <h4>{{post.title}}</h4>
            <p>{{post.body}}</p>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" @click="editPost(post)">Edit</button>
            <button type="button" class="btn btn-danger" @click="deletePost(post.id)">Delete</button>
            <hr>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return {
            posts: {},
            edit:false,
            post:
            {
                id:'',
                title:'',
                body:''
            },
            errors:[]
        }
    },
    created()
    {
        this.getPosts()
    },
    methods:
    {
        getPosts()
        {
            axios.get('api/getPosts').then(response =>{
                this.posts = response.data.data
            })
        },
        createPost()
        {
            //let token = localStorage.setItem('token')
            //?token='+token
            axios.post('api/createPost',this.post).then(response=>
            {
                if(response.data.status=='error')
                {
                    this.errors = response.data.errors
                }
                else if(response.data.status=='success')
                {
                    Toast.fire({
                        icon: 'success',
                        title: 'Created successfully'
                    })
                    this.post =
                    {
                        id:'',
                        title:'',
                        body:''
                    }
                    this.edit = false
                    this.errors = []
                    this.getposts()
                    this.$router.push({name:'Post'})
                }
            })
        },
        editPost(post)
        {
            this.post = post
            this.edit = true
        },
        updatePost()
        {
            //let token = localStorage.setItem('token')
            //+'?token='+token
            axios.put('api/updatePost/'+this.post.id,this.post).then(response=>
            {
                if(response.data.status=='error')
                {
                    this.errors = response.data.errors
                }
                else
                {
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated successfully'
                    })
                    this.post =
                    {
                        id:'',
                        title:'',
                        body:''
                    }
                    this.edit = false
                    this.errors = []
                    this.getposts()
                    this.$router.push({name:'Post'})
                }
            })
        },
        deletePost(id)
        {
            //let token = localStorage.setItem('token')
            //+'?token='+token
            Swal.fire(
            {
                title: 'Are You Sure?',
                text: "You Wont't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result)=>
            {
                if(result.isConfirmed)
                {
                    axios.delete('api/deletePost/'+id).then(response=>
                    {
                        if(response.data.status=='success')
                        {
                            Swal.fire
                            (
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            this.getposts()
                            this.$router.push({name:'Post'})
                        }
                    })
                }
            })
        }
    },
}
</script>
