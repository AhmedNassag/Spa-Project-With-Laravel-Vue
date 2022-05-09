<template>
    <div class="text-center">
        <router-link to="/register" class="btn btn-primary m-1">Register</router-link>
        <router-link to="/login" class="btn btn-primary m-1">Login</router-link>
        <router-link to="/" class="btn btn-primary m-1">Posts</router-link>
        <button class="btn btn-primary m-1" @click="logout">Logout</button>
    </div>
</template>

<script>
export default
{
    data()
    {
        return {

        }
    },
    methods:
    {
        logout()
        {
            let token = localStorage.getItem('token')
            axios.post('api/logout?token='+token).then(response=>
            {
                localStorage.setItem('token','')
            })

                this.$router.push({name:'Login'})
        }
    }
}
</script>
