<template>
    <div>
        <input type="text" class="form-control m-1" placeholder="Enter Email" v-model="user.email">
        <input type="password" class="form-control m-1" placeholder="Enter Password" v-model="user.password">
        <button class="btn btn-primary btn-block m-1" @click="login">Login</button>
        <div v-if="error" class="alert alert-danger">Error</div>
    </div>
</template>

<script>
export default {
    data()
    {
        return {
            user:
            {
                email:'',
                password:''
            },
            error:false
        }
    },
    methods:
    {
        login()
        {
            axios.post('api/login',this.user).then(response=>
            {
                if(response.data.status=='success')
                {
                    let token = response.data.token
                    localStorage.setItem('token',token)
                    this.error = false
                    this.$router.push({name:'Post'})
                }
                else
                {
                    this.error = true
                }
            })
        }
    }
}
</script>
