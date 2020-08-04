
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
const storesupplier = require('./components/suppliers/create').default;
const editsupplier = require('./components/suppliers/edit').default;
const indexsupplier = require('./components/suppliers/index').default;

/*CATEGORY*/
const storecategory = require('./components/categories/create').default;
const editcategory = require('./components/categories/edit').default;
const indexcategory = require('./components/categories/index').default;

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

    /*SUPPLIER*/
    { path: '/store-supplier', component: storesupplier, name: 'store-supplier' },
    { path: '/edit-supplier/:id', component: editsupplier, name: 'edit-supplier' },
    { path: '/index-supplier', component: indexsupplier, name: 'index-supplier' },

    /*CATEGORY*/
    { path: '/store-category', component: storecategory, name: 'store-category' },
    { path: '/edit-category/:id', component: editcategory, name: 'edit-category' },
    { path: '/index-category', component: indexcategory, name: 'index-category' },
];
