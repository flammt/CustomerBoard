
require('./bootstrap');

import Vue from 'vue'
import App from './components/login/App.vue'

const app = new Vue({
    //router,
    render: h => h(App),
}).$mount('#app')
