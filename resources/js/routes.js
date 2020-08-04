
/*AUTH*/
const login = require('./components/auth/login').default;
const register = require('./components/auth/register').default;
const forget = require('./components/auth/forget').default;
const logout = require('./components/auth/logout').default;

/*HOME*/
const home = require('./components/home').default;

/*EMPLOYEE*/
const storeemployee = require('./components/employee/create').default;
const editemployee = require('./components/employee/edit').default;
const indexemployee = require('./components/employee/index').default;

/*SUPPLIER*/
// const storesupplier = require('./components/suppliers/create').default;
// const indexsupplier = require('./components/suppliers/index').default;


export const routes = [

    /*AUTH*/
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forget', component: forget, name: 'forget' },
    { path: '/logout', component: logout, name: 'logout' },

    /*HOME*/
    { path: '/home', component: home, name: 'home' },

    /*EMPLOYEE*/
    { path: '/store-employee', component: storeemployee, name: 'store-employee' },
    { path: '/edit-employee/:id', component: editemployee, name: 'edit-employee' },
    { path: '/index-employee', component: indexemployee, name: 'index-employee' },


];
