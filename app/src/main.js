// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from '@/App';
import router from '@/router/loader.js';
import vue_meta from 'vue-meta';

import Notifications from 'vue-notification';

// Vue.config.productionTip = false

Vue.use(vue_meta);
Vue.use(Notifications);

/* eslint-disable no-new */
new Vue({
	el: '#app',
	router,
	render: h => h(App)
});