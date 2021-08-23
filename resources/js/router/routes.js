import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Home from '../views/HomeDashboard'
import Products from '../views/Products'
import Sales from '../views/Sales'
import Categories from '../views/Categories'
import RegisterSale from '../views/RegisterSale'
import Reports from '../views/Reports'
import Page404 from '../views/Page404'

export default new VueRouter({
    linkExactActiveClass: 'active',
    routes: [{
        path: '/',
        component: Home
    }, {
        path: '/produtos',
        component: Products
    }, {
        path: '/vendas',
        component: Sales
    }, {
        path: '/categorias',
        component: Categories
    }, {
        path: '/registrar-venda',
        component: RegisterSale
    }, {
        path: '/relatorios',
        component: Reports
    }, {
        path: '*',
        component: Page404,
    }]
})