
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

/*PRODUCT*/
const storeproducts = require('./components/products/create').default;
const editproducts = require('./components/products/edit').default;
const indexproducts = require('./components/products/index').default;

/*EXPENSE*/
const storeexpenses = require('./components/expenses/create').default;
const editexpenses = require('./components/expenses/edit').default;
const indexexpenses= require('./components/expenses/index').default;

/*SALARY*/
const salary = require('./components/salaries/all_employee').default;
const paysalary = require('./components/salaries/create').default;
const allsalary = require('./components/salaries/index').default;
const viewsalary = require('./components/salaries/view').default;
const editsalary = require('./components/salaries/edit').default;

/*STOC*/
const stock= require('./components/products/stock').default;
const editstock= require('./components/products/edit-stock').default;

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

    /*PRODUCT*/
    { path: '/store-product', component: storeproducts, name: 'store-product' },
    { path: '/edit-product/:id', component: editproducts, name: 'edit-product' },
    { path: '/index-product', component: indexproducts, name: 'index-product' },

    /*EXPENSE*/
    { path: '/store-expense', component: storeexpenses, name: 'store-expense' },
    { path: '/edit-expense/:id', component: editexpenses, name: 'edit-expense' },
    { path: '/index-expense', component: indexexpenses, name: 'index-expense' },

    /*SALARY*/
    { path: '/given-salary', component: salary, name: 'given-salary' },
    { path: '/pay-salary/:id', component: paysalary, name: 'pay-salary' },
    { path: '/salary', component: allsalary, name: 'salary' },
    { path: '/view-salary/:salary_year/:salary_month', component: viewsalary, name: 'view-salary' },
    { path: '/edit-salary/:id', component: editsalary, name: 'edit-salary' },

    /*STOCK*/
    { path: '/stock', component: stock, name: 'stock' },
    { path: '/edit-stock/:id', component: editstock, name: 'edit-stock' },
];
