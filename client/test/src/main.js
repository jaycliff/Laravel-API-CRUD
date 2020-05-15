import Vue from 'vue';
import App from './App.vue';

import { router } from './router';

Vue.config.productionTip = false;
console.log(App, router);

new Vue({
    router,
    render: function (h) {
        console.log(h);
        return h(App);
    }
}).$mount('#app');