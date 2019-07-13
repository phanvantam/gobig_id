// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from '@/App';
import router from '@/router/index.js';
import vue_meta from 'vue-meta';
import store from '@/store/index.js';
import Notifications from 'vue-notification';
import Helper from '@/helper/loader.js';

Vue.config.productionTip = false

Vue.use(vue_meta);
Vue.use(Helper);
Vue.use(Notifications);

/* eslint-disable no-new */
new Vue({
	el: '#app',
	store,
	router,
	render: h => h(App)
});