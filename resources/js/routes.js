let routes = [
    {
        path : '/dashboard',
        component : require('./components/Dashboard.vue').default
    },
    {
        path : '/members',
        component : require('./components/Members.vue').default
    },
    {
        path : '/developer',
        component : require('./components/Developer.vue').default
    },
    {
        path : '/leaveconfig',
        component : require('./components/LeaveSetting.vue').default
    },
    {
        path : '/department',
        component : require('./components/Department.vue').default
    },
    {
        path : '/holidayconfig',
        component : require('./components/HolidayConfig.vue').default
    },
    {
        path : '/roles',
        component : require('./components/Roles.vue').default
    },
    {
        path : '/leave',
        component : require('./components/Leave.vue').default
    },
    {
        path : '/profile',
        component : require('./components/Profile.vue').default
    },
    {
        path : '*',
        component : require('./components/NotFound.vue').default
    }
];

export default routes
