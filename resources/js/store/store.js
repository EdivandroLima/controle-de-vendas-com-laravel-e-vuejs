import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        appTitle: 'Controle de vendas',
        configHeader: {
            headers: {
                Authorization: 'Bearer ' + window.Laravel.api_token,
                Accept: 'application/json'
            }
        },
    },
})