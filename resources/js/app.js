
require('./bootstrap');
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
import router from './router/routes'
import Dialog from 'vue-dialog-loading'
import store from './store/store'
import VueMeta from 'vue-meta'

window.Vue = require('vue').default;
Vue.use(Dialog, {
    dialogBtnColor: '#0f0'
})
Vue.use(VueMeta)
Vue.filter('moeda', value => {
    return parseInt(value).toLocaleString("pt-BR", { minimumFractionDigits: 2 , style: 'currency', currency: 'BRL' });
});

Vue.component('app-layout', require('./components/layout/AppLayout.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store
});
