
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import {Form,HasError,AlertError} from 'vform'
import moment from 'moment'
import VueProgressBar from 'vue-progressbar'
import swal from 'sweetalert2'
// import routes from './routes'
import Gate from './Gate'

Vue.prototype.$gate = new Gate(window.user);

window.swal = swal
window.toast = toast
window.Form = Form;
window.fire = new Vue();

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
})

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
})


Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.use(VueRouter)

let routes = [
    {path : '/dashboard',component : require('./components/Dashboard.vue').default},
    {path : '/members',component : require('./components/Members.vue').default},
    {path : '/developer',component : require('./components/Developer.vue').default},
    {path : '/leaveconfig',component : require('./components/LeaveSetting.vue').default},
    {path : '/department',component : require('./components/Department.vue').default},
    {path : '/holidayconfig',component : require('./components/HolidayConfig.vue').default},
    {path : '/roles',component : require('./components/Roles.vue').default},
    {path : '/leave',component : require('./components/Leave.vue').default},
    {path : '/profile',component : require('./components/Profile.vue').default},
    {path : '*',component : require('./components/NotFound.vue').default}
];

const router = new VueRouter({
    mode : 'history',
    routes
});

Vue.filter('upText',function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('MyDate',function(created){
    return moment(created).format('MMMM Do YYYY')
});

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router,
    data : {
        search : ''
    },
    methods : {
        searchit : _.debounce(() => {
            fire.$emit('Searching')
        },1000),

        printme() {
            window.print();
        }
    },
});
