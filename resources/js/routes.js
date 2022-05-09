import Register from './components/Register';
import Login from './components/Login';
import Post from './components/Post';

const routes =
[
    {path:'/register',component:Register,name:'Register'},
    {path:'/login',component:Login,name:'Login'},
    {path:'/',component:Post,name:'Post'},
]

export default routes
