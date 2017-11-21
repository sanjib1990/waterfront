import VueRouter from 'vue-router';
import Task from './components/Task.vue';
import Profile from './components/Profile.vue';
import Welcome from './components/Welcome.vue';

let routes = [
    {
        path: '/',
        component: Welcome
    },
    {
        path: '/task',
        component: Task
    },
    {
        path: '/profile',
        component: Profile
    }
];


export default new VueRouter({
    routes
});